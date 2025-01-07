<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Профиль пациента | DentalBook</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
        }

        .profile-card {
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .profile-icon {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100px;
            width: 100px;
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 50%;
            margin: auto;
        }

        .actions {
            display: flex;
            gap: 10px;
            margin-bottom: 15px;
        }

        .tabs {
            margin-top: 20px;
        }

        .table-container {
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .btn-add {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
<?php include 'navbar.php'; ?>
    <div class="container mt-5">
        <h2 class="mb-4">Профиль пациента | DentalBook</h2>

        <!-- Карточка профиля -->
        <div id="patientProfile" class="profile-card mb-4">
            <div class="text-center">Загрузка данных...</div>
        </div>

        <!-- Действия -->
        <div class="actions">
            <button class="btn btn-primary"><i class="fas fa-file-alt"></i> Анкета</button>
            <button class="btn btn-secondary"><i class="fas fa-file-contract"></i> Договор</button>
            <button class="btn btn-info"><i class="fas fa-star"></i> Оценка</button>
            <button class="btn btn-danger"><i class="fas fa-print"></i> Печать</button>
        </div>

        <!-- Вкладки -->
        <div class="tabs">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" href="#"><i class="fas fa-calendar-check"></i> Визиты</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fas fa-tooth"></i> Формула</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fas fa-dollar-sign"></i> Оплаты</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fas fa-notes-medical"></i> План лечения</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fas fa-image"></i> Снимки</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fas fa-sticky-note"></i> Примечания</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fas fa-folder"></i> Документы</a>
                </li>
            </ul>
        </div>

        <!-- Таблица визитов -->
        <div class="table-container">
            <button class="btn btn-primary btn-add" data-bs-toggle="modal" data-bs-target="#addVisitModal">Добавить визит</button>
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
                                <input type="text" id="patientFullName" class="form-control" placeholder="Введите ФИО пациента" readonly>
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
        // Заполняем временные интервалы
        document.addEventListener('DOMContentLoaded', () => {
            const visitTimeSelect = document.getElementById('visitTime');
            const startTime = new Date('1970-01-01T09:00:00');
            const endTime = new Date('1970-01-01T17:30:00');
            const interval = 30; // Интервал в минутах

            while (startTime <= endTime) {
                const option = document.createElement('option');
                option.value = startTime.toTimeString().substring(0, 5);
                option.textContent = startTime.toTimeString().substring(0, 5);
                visitTimeSelect.appendChild(option);
                startTime.setMinutes(startTime.getMinutes() + interval);
            }
        });

        // Получение ID карты пациента из параметров URL
        function getPatientCardId() {
            const params = new URLSearchParams(window.location.search);
            return params.get('patientCardId');
        }

        // Получение токена из cookies
        function getCookie(name) {
            const value = `; ${document.cookie}`;
            const parts = value.split(`; ${name}=`);
            if (parts.length === 2) return parts.pop().split(';').shift();
        }
        // Функции для загрузки профиля пациента и визитов
        document.addEventListener('DOMContentLoaded', async () => {
            const patientCardId = new URLSearchParams(window.location.search).get('patientCardId');
            const token = document.cookie.split('; ').find(row => row.startsWith('token=')).split('=')[1];

            async function loadPatientProfile() {
                const response = await fetch(`http://localhost:3003/api/patient-cards/get/patient_profile/${patientCardId}`, {
                    headers: { Authorization: `Bearer ${token}` }
                });
                const data = await response.json();
                document.getElementById('patientProfile').innerHTML = `
                    <div class="row">
                        <div class="col-md-9">
                            <p><strong><i class="fas fa-user"></i> ФИО:</strong> ${data.profile.fullName}</p>
                            <p><strong><i class="fas fa-calendar"></i> Дата рождения:</strong> ${data.profile.dateOfBirth}</p>
                            <p><strong><i class="fas fa-file-alt"></i> Полис:</strong> ${data.profile.policy}</p>
                            <p><strong><i class="fas fa-phone"></i> Контактный телефон:</strong> ${data.profile.phoneNumber}</p>
                            <p><strong><i class="fas fa-envelope"></i> Email:</strong> ${data.profile.email}</p>
                            <p><strong><i class="fas fa-map-marker-alt"></i> Адрес:</strong> ${data.profile.address}</p>
                            <p><strong><i class="fas fa-clock"></i> Последний вход:</strong> ${data.profile.lastLogin}</p>
                        </div>
                        <div class="col-md-3 text-center">
                            <div class="profile-icon">
                                <i class="fas fa-user fa-3x"></i>
                            </div>
                        </div>
                    </div>`;

                // Подставить ФИО пациента в модальное окно
                document.getElementById('patientFullName').value = data.profile.fullName;
            }

            async function loadVisits() {
                const response = await fetch(`http://localhost:3003/api/patient-cards/visit/all/${patientCardId}`, {
                    headers: { Authorization: `Bearer ${token}` }
                });
                const data = await response.json();
                const tableBody = document.getElementById('visitsTableBody');
                tableBody.innerHTML = data.visits.map(visit => `
                    <tr>
                        <td>${visit.id}</td>
                        <td>${visit.visitDate}</td>
                        <td>${visit.visitTime}</td>
                        <td>${visit.visitType}</td>
                        <td>${visit.doctor.firstName} ${visit.doctor.lastName}</td>
                        <td>${visit.visitStatus}</td>
                        <td>
                            <button class="btn btn-sm btn-info"><i class="fas fa-eye"></i></button>
                            <button class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>`).join('');
            }

            document.getElementById('saveVisitButton').addEventListener('click', async () => {
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
                    loadVisits();
                } else {
                    alert('Ошибка при добавлении визита');
                }
            });

            await loadPatientProfile();
            await loadVisits();
        });
    </script>
</body>
</html>
