<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>История медицинских записей</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 1200px;
            background: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }
        h1 {
            color: #007bff;
            font-size: 24px;
            margin-bottom: 20px;
        }
        .btn-info {
            background-color: #17a2b8;
            border-color: #17a2b8;
            color: white;
        }
        .btn-info:hover {
            background-color: #138496;
            border-color: #117a8b;
        }
        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
            color: white;
        }
        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }
    </style>
</head>
<body>
    <?php include '../users/profile.php'; ?>
    <?php include '../adminpanel/navbar.php'; ?>
    <div class="container">

        <!-- Таблица медицинских записей -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Дата</th>
                    <th>Тип записи</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody id="recordTableBody">
                <!-- Данные записей будут загружены динамически -->
            </tbody>
        </table>
    </div>

    <!-- Модальное окно для просмотра записи -->
    <div class="modal fade" id="viewRecordModal" tabindex="-1" aria-labelledby="viewRecordModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content shadow">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="viewRecordModalLabel">Детали записи</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="recordDate" class="form-label fw-semibold">Дата записи</label>
                            <input type="text" id="recordDate" class="form-control" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="recordType" class="form-label fw-semibold">Тип записи</label>
                            <input type="text" id="recordType" class="form-control" disabled>
                        </div>
                        <div id="dynamicFields">
                            <!-- Динамически создаваемые формы -->
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const API_URL = 'http://localhost:3003/api/patient-cards/examinationsheet/get';
        const DELETE_URL = 'http://localhost:3003/api/admin/examination-sheet';
        const patientCardId = new URLSearchParams(window.location.search).get('patientCardId');

        // Функция для получения токена из cookies
        function getCookie(name) {
            const value = `; ${document.cookie}`;
            const parts = value.split(`; ${name}=`);
            if (parts.length === 2) return parts.pop().split(';').shift();
        }

        // Функция для загрузки данных
        async function loadRecords() {
            const token = getCookie('token');
            try {
                const response = await fetch(`${API_URL}/${patientCardId}`, {
                    method: 'GET',
                    headers: {
                        'Authorization': `Bearer ${token}`
                    }
                });

                if (!response.ok) {
                    throw new Error('Ошибка загрузки данных записей');
                }

                const { data } = await response.json();
                populateTable(data.simplified);
            } catch (error) {
                console.error('Ошибка:', error);
                alert('Не удалось загрузить данные записей.');
            }
        }

        // Функция для заполнения таблицы
        function populateTable(records) {
            const tableBody = document.getElementById('recordTableBody');
            tableBody.innerHTML = ''; // Очищаем таблицу

            records.forEach(record => {
                const date = new Date(record.createdAt).toLocaleDateString();

                const row = document.createElement('tr');
                row.id = `record-${record.id}`;
                row.innerHTML = `
                    <td>${record.id}</td>
                    <td>${date}</td>
                    <td>${record.type}</td>
                    <td class="table-actions">
                        <button class="btn btn-info btn-sm" onclick="viewRecordDetails(${record.id})">
                            <i class="fas fa-eye"></i> Просмотреть
                        </button>
                        <button class="btn btn-danger btn-sm" onclick="deleteRecord(${record.id})">
                            <i class="fas fa-trash"></i> Удалить
                        </button>
                    </td>
                `;
                tableBody.appendChild(row);
            });
        }

        // Функция для отображения подробной информации
        async function viewRecordDetails(id) {
            const token = getCookie('token');
            try {
                const response = await fetch(`${API_URL}/${patientCardId}`, {
                    method: 'GET',
                    headers: {
                        'Authorization': `Bearer ${token}`
                    }
                });

                if (!response.ok) {
                    throw new Error('Ошибка загрузки данных записи');
                }

                const { data } = await response.json();
                const record = Object.values(data.grouped).flat().find(item => item.id === id);

                if (record) {
                    updateModalContent(record);
                }
            } catch (error) {
                console.error('Ошибка:', error);
                alert('Не удалось загрузить данные записи.');
            }
        }

        // Обновление содержимого модального окна
        function updateModalContent(record) {
            document.getElementById('recordDate').value = new Date(record.createdAt).toLocaleDateString() || 'Нет данных';
            document.getElementById('recordType').value = record.type || 'Нет данных';

            const dynamicFields = document.getElementById('dynamicFields');
            dynamicFields.innerHTML = '';

            const fields = {
                'Жалобы': record.complaints,
                'Диагноз': record.preliminaryDiagnosis,
                'Рекомендации': record.doctorRecommendations,
                'Динамика состояния': record.conditionDynamics,
                'Результаты лечения': record.treatmentResults,
                'Цель чистки': record.cleaningGoal,
                'Процедура чистки': record.cleaningProcedure,
                'Дополнительные процедуры': record.additionalCleaningProcedures,
                'Состояние после чистки': record.postCleaningCondition,
                'Описание проблемы': record.problemDescription,
                'Оценка состояния': record.conditionAssessment,
                'Принятые меры': record.measuresTaken
            };

            for (const [label, value] of Object.entries(fields)) {
                if (value !== null && value !== undefined) {
                    const field = document.createElement('div');
                    field.classList.add('mb-3');
                    field.innerHTML = `
                        <label class="form-label fw-semibold">${label}</label>
                        <input type="text" class="form-control" value="${value}" disabled>
                    `;
                    dynamicFields.appendChild(field);
                }
            }

            const modal = new bootstrap.Modal(document.getElementById('viewRecordModal'));
            modal.show();
        }

        // Удаление записи
        async function deleteRecord(id) {
            const token = getCookie('token');

            if (!confirm('Вы уверены, что хотите удалить запись?')) return;

            try {
                const response = await fetch(`${DELETE_URL}/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Authorization': `Bearer ${token}`
                    }
                });

                if (!response.ok) {
                    throw new Error('Ошибка при удалении записи');
                }

                // Убираем строку из таблицы после удаления
                const row = document.getElementById(`record-${id}`);
                if (row) row.remove();

                alert('Запись успешно удалена');
            } catch (error) {
                console.error('Ошибка при удалении:', error);
                alert('Не удалось удалить запись.');
            }
        }

        document.addEventListener('DOMContentLoaded', loadRecords);
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>