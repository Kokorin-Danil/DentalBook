<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Профиль пациента | DentalBook</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/jwt-decode@3.1.2/build/jwt-decode.min.js"></script>
</head>
<body>
    <?php include 'profile.php'; ?>
    <?php include 'navbar.php'; ?>

    <div class="container mt-5">
        <!-- Таблица визитов -->
        <div class="table-container">
            <!-- Кнопка добавления визита только для не-администратора -->
            <button class="btn btn-primary btn-add" id="addVisitButton" data-bs-toggle="modal" data-bs-target="#addVisitModal">Добавить визит</button>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Дата</th>
                        <th>Время</th>
                        <th>Тип</th>
                        <th>Врач</th>
                        <th>Статус</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody id="visitsTableBody">
                    <!-- Данные визитов будут загружены динамически -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Модальное окно -->
    <div class="modal fade" id="addVisitModal" tabindex="-1" aria-labelledby="addVisitModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Заголовок модального окна -->
                <div class="modal-header">
                    <h5 class="modal-title" id="addVisitModalLabel">Новый визит</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                </div>

                <!-- Тело модального окна -->
                <div class="modal-body">
                    <form id="visitForm">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="patientFullName" class="form-label">ФИО пациента</label>
                                <input type="text" id="patientFullName" class="form-control" placeholder="Введите ФИО пациента">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="doctorFullName" class="form-label">ФИО врача</label>
                                <input type="text" id="doctorFullName" class="form-control" placeholder="Введите ФИО врача" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="visitType" class="form-label">Тип визита</label>
                                <select id="visitType" class="form-select" required>
                                    <option value="осмотр" selected>Осмотр</option>
                                    <option value="лечение">Лечение</option>
                                    <option value="консультация">Консультация</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="visitDate" class="form-label">Дата визита</label>
                                <input type="date" id="visitDate" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label for="visitTime" class="form-label">Время визита</label>
                                <select id="visitTime" class="form-select" required>
                                    <!-- Временные интервалы заполняются автоматически -->
                                </select>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Подвал модального окна -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                    <button type="button" id="saveVisitButton" class="btn btn-primary">Сохранить</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Функция для декодирования токена и получения роли
        function getRoleFromToken() {
            const token = getCookie('token');
            if (token) {
                const decoded = jwt_decode(token);
                return decoded.role;  // Предполагаем, что роль хранится в поле 'role'
            }
            return null;
        }

        // Заполняем временные интервалы
        document.addEventListener('DOMContentLoaded', () => {
            const visitTimeSelect = document.getElementById('visitTime');
            const startTime = new Date('1970-01-01T09:00:00');
            const endTime = new Date('1970-01-01T17:30:00');
            const interval = 30;

            while (startTime <= endTime) {
                const option = document.createElement('option');
                option.value = startTime.toTimeString().substring(0, 5);
                option.textContent = startTime.toTimeString().substring(0, 5);
                visitTimeSelect.appendChild(option);
                startTime.setMinutes(startTime.getMinutes() + interval);
            }
        });

        // Загрузка данных пациента и визитов
        document.addEventListener('DOMContentLoaded', async () => {
            const patientCardId = new URLSearchParams(window.location.search).get('patientCardId');
            const token = getCookie('token');
            const role = getRoleFromToken();  // Получаем роль из токена

            // Если роль администратора, скрываем кнопку добавления визита
            if (role === 'admin') {
                document.getElementById('addVisitButton').style.display = 'none';
            }

            async function loadPatientProfile() {
                const response = await fetch(`http://localhost:3003/api/patient-cards/get/patient_profile/${patientCardId}`, {
                    headers: { Authorization: `Bearer ${token}` }
                });
                const data = await response.json();

                // Устанавливаем ФИО пациента
                document.getElementById('patientFullName').value = data.profile.fullName;
            }

            async function loadVisits() {
                const response = await fetch(`http://localhost:3003/api/patient-cards/visit/all/${patientCardId}`, {
                    headers: { Authorization: `Bearer ${token}` }
                });
                const data = await response.json();

                const tableBody = document.getElementById('visitsTableBody');
                tableBody.innerHTML = data.visits.map(visit => `
                    <tr id="visit-${visit.id}">
                        <td>${visit.id}</td>
                        <td>${visit.visitDate}</td>
                        <td>${visit.visitTime}</td>
                        <td>${visit.visitType}</td>
                        <td>${visit.doctor.firstName} ${visit.doctor.lastName}</td>
                        <td>${visit.visitStatus}</td>
                        <td>
                            <button class="btn btn-sm btn-info"><i class="fas fa-eye"></i></button>
                            <button class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-sm btn-danger" onclick="deleteVisit(${visit.id})">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `).join('');
            }

            async function saveVisit() {
                const visitData = {
                    patientFullName: document.getElementById('patientFullName').value,
                    visitType: document.getElementById('visitType').value,
                    visitDate: document.getElementById('visitDate').value,
                    visitTime: document.getElementById('visitTime').value,
                    doctorFullName: document.getElementById('doctorFullName').value
                };

                const response = await fetch('http://localhost:3003/api/patient-cards/visit/create', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        Authorization: `Bearer ${token}`
                    },
                    body: JSON.stringify(visitData)
                });

                if (response.ok) {
                    alert('Визит успешно добавлен!');
                    document.getElementById('visitForm').reset();
                    await loadVisits();
                } else {
                    alert('Ошибка при добавлении визита');
                }
            }

            document.getElementById('saveVisitButton').addEventListener('click', saveVisit);
            await loadPatientProfile();
            await loadVisits();
        });

        // Удаление визита
        async function deleteVisit(visitId) {
            const token = getCookie('token');
            if (!token) {
                alert('Необходима авторизация администратора.');
                return;
            }

            if (!confirm('Вы уверены, что хотите удалить этот визит?')) return;

            try {
                const response = await fetch(`http://localhost:3003/api/admin/visit/${visitId}`, {
                    method: 'DELETE',
                    headers: { Authorization: `Bearer ${token}` }
                });

                if (!response.ok) {
                    throw new Error(`Ошибка HTTP: ${response.status}`);
                }

                // Убираем строку визита из таблицы после удаления
                document.getElementById(`visit-${visitId}`).remove();

                alert('Визит успешно удален.');
            } catch (error) {
                console.error('Ошибка удаления визита:', error);
                alert('Не удалось удалить визит.');
            }
        }

        // Получение токена из cookies
        function getCookie(name) {
            const value = `; ${document.cookie}`;
            const parts = value.split(`; ${name}=`);
            if (parts.length === 2) return parts.pop().split(';').shift();
        }
    </script>
</body>
</html>
