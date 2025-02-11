<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Пациенты</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .table-container {
            background: #ffffff;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .avatar-img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }
    </style>
</head>
<body>
<?php include 'navbar.php'; ?>

    <div class="container mt-4">
        <!-- Tabs Navigation -->
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" id="patients-tab" href="patients.php">
                    <i class="fas fa-users"></i> Пациенты
                </a>
            </li>
        </ul>

        <div class="tab-content mt-4">
            <div class="tab-pane fade show active" id="patients">
                <div class="header-section">
                    <h1 class="h4">Список пациентов</h1>
                </div>
                <div class="table-container">
                    <table class="table">
                        <thead class="table-light">
                            <tr>
                                <th>Id</th>
                                <th>Фото</th>
                                <th>ФИО</th>
                                <th>Email</th>
                                <th>Телефон</th>
                                <th>Дата рождения</th>
                                <th>Адрес</th>
                                <th>Полис</th>
                                <th>СНИЛС</th>
                                <th>Паспорт</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody id="patientTableBody">
                            <!-- Данные пациентов -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="editPatientModal" tabindex="-1" aria-labelledby="editPatientModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPatientModalLabel">Редактировать профиль</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editPatientForm">
                        <input type="hidden" id="editPatientId">

                        <!-- Поля редактирования -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="editFirstName" class="form-label">Имя:</label>
                                <input type="text" class="form-control" id="editFirstName" required>
                            </div>
                            <div class="col-md-6">
                                <label for="editLastName" class="form-label">Фамилия:</label>
                                <input type="text" class="form-control" id="editLastName" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="editPatronymic" class="form-label">Отчество:</label>
                                <input type="text" class="form-control" id="editPatronymic">
                            </div>
                            <div class="col-md-6">
                                <label for="editGender" class="form-label">Пол:</label>
                                <select class="form-select" id="editGender">
                                    <option value="male">Мужчина</option>
                                    <option value="female">Женщина</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="editDateOfBirth" class="form-label">Дата рождения:</label>
                                <input type="date" class="form-control" id="editDateOfBirth" required>
                            </div>
                            <div class="col-md-6">
                                <label for="editAddress" class="form-label">Адрес:</label>
                                <input type="text" class="form-control" id="editAddress">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="editEmail" class="form-label">Email:</label>
                                <input type="email" class="form-control" id="editEmail" required>
                            </div>
                            <div class="col-md-6">
                                <label for="editPhoneNumber" class="form-label">Телефон:</label>
                                <input type="text" class="form-control" id="editPhoneNumber" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="editPolicyNumber" class="form-label">Полис:</label>
                                <input type="text" class="form-control" id="editPolicyNumber">
                            </div>
                            <div class="col-md-6">
                                <label for="editSnils" class="form-label">СНИЛС:</label>
                                <input type="text" class="form-control" id="editSnils">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="editPassport" class="form-label">Паспорт:</label>
                                <input type="text" class="form-control" id="editPassport">
                            </div>
                        </div>

                        <!-- Загрузка аватара -->
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="editAvatar" class="form-label">Обновить аватар:</label>
                                <input type="file" class="form-control" id="editAvatar">
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Отмена</button>
                            <button type="submit" class="btn btn-primary">Сохранить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.7/jquery.inputmask.min.js"></script>
    <script type="module">
    import { getToken, parseJwt } from "/js/auth.js";

    function checkAccess() {
        const token = getToken();

        if (!token) {
            alert('Вы не авторизованы!');
            window.location.replace('/index.php');
            return;
        }

        const decodedToken = parseJwt(token);
        const userRole = decodedToken?.role;

        if (userRole !== 'admin') {
            alert('У вас нет доступа к этой странице!');
            if (document.referrer) {
                window.location.href = document.referrer; // Возвращаем на предыдущую страницу
            } else {
                window.location.replace('/index.php'); // Если истории нет, направляем на auth.php
            }
        }
    }

    checkAccess();
</script>
    <script>
        function getAdminToken() {
            const cookies = document.cookie.split('; ');
            const tokenCookie = cookies.find(row => row.startsWith('token='));
            return tokenCookie ? tokenCookie.split('=')[1] : null;
        }

        async function fetchData(url) {
            const token = getAdminToken();
            if (!token) {
                alert('Необходима авторизация администратора.');
                return null;
            }

            try {
                const response = await fetch(url, {
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Content-Type': 'application/json',
                    },
                });

                if (!response.ok) {
                    throw new Error(`Ошибка HTTP: ${response.status}`);
                }
                return await response.json();
            } catch (error) {
                console.error('Ошибка запроса:', error);
                alert('Не удалось загрузить данные.');
                return null;
            }
        }

        async function loadPatients() {
            const data = await fetchData('http://localhost:3003/api/admin/patients/get');
            if (!data || !data.patients) return;

            const patientTableBody = document.getElementById('patientTableBody');
            patientTableBody.innerHTML = data.patients.map(patient => `
                <tr>
                    <td>${patient.patientId}</td>
                    <td>
                        <img src="${patient.avatar || '/backend/uploads/avatars/default_avatar.png'}" alt="Аватар" class="avatar-img">
                    </td>
                    <td>${patient.lastName} ${patient.firstName} ${patient.patronymic}</td>
                    <td>${patient.email}</td>
                    <td>${patient.phoneNumber}</td>
                    <td>${patient.dateOfBirth}</td>
                    <td>${patient.address}</td>
                    <td>${patient.policyNumber}</td>
                    <td>${patient.snils}</td>
                    <td>${patient.passport}</td>
                    <td class="action-buttons">
                        <a href="/users/view.php?patientCardId=${patient.patientId}" class="btn btn-sm btn-info">
                            <i class="fas fa-eye"></i>
                        </a>
                        <button class="btn btn-sm btn-warning" onclick="openEditModal(${patient.patientId}, ${JSON.stringify(patient).replace(/"/g, '&quot;')})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger" onclick="deletePatient(${patient.patientId})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `).join('');
        }

        function openEditModal(patientId, patient) {
            document.getElementById('editPatientId').value = patientId;
            document.getElementById('editFirstName').value = patient.firstName || '';
            document.getElementById('editLastName').value = patient.lastName || '';
            document.getElementById('editPatronymic').value = patient.patronymic || '';
            document.getElementById('editDateOfBirth').value = patient.dateOfBirth || '';
            document.getElementById('editAddress').value = patient.address || '';
            document.getElementById('editPhoneNumber').value = patient.phoneNumber || '';
            document.getElementById('editPolicyNumber').value = patient.policyNumber || '';
            document.getElementById('editSnils').value = patient.snils || '';
            document.getElementById('editPassport').value = patient.passport || '';
            document.getElementById('editEmail').value = patient.email || '';

            const modal = new bootstrap.Modal(document.getElementById('editPatientModal'));
            modal.show();
        }

        async function uploadAvatar(patientId) {
            const avatarInput = document.getElementById('editAvatar');
            if (!avatarInput.files.length) return null;

            const formData = new FormData();
            formData.append('avatar', avatarInput.files[0]);

            const token = getAdminToken();
            if (!token) {
                alert('Необходима авторизация администратора.');
                return;
            }

            try {
                const response = await fetch(`http://localhost:3003/api/admin/patients/avatar/update/${patientId}`, {
                    method: 'PUT',
                    headers: {
                        'Authorization': `Bearer ${token}`
                    },
                    body: formData
                });

                if (!response.ok) {
                    throw new Error(`Ошибка HTTP: ${response.status}`);
                }

                const result = await response.json();
                alert(result.message);
                return result.avatar; // Возвращаем путь к новому аватару
            } catch (error) {
                console.error('Ошибка обновления аватара:', error);
                alert('Не удалось обновить аватар.');
                return null;
            }
        }

        async function deletePatient(patientId) {
            const token = getAdminToken();
            if (!token) {
                alert('Необходима авторизация администратора.');
                return;
            }

            if (!confirm('Вы уверены, что хотите удалить этого пациента?')) return;

            try {
                const response = await fetch(`http://localhost:3003/api/patient-cards/card/${patientId}`, {
                    method: 'DELETE',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Content-Type': 'application/json',
                    },
                });

                if (!response.ok) {
                    throw new Error(`Ошибка HTTP: ${response.status}`);
                }

                alert('Пациент успешно удален.');
                loadPatients();
            } catch (error) {
                console.error('Ошибка удаления:', error);
                alert('Не удалось удалить пациента.');
            }
        }

        document.getElementById('editPatientForm').addEventListener('submit', async (event) => {
            event.preventDefault();

            const patientId = document.getElementById('editPatientId').value;
            const payload = {
                firstName: document.getElementById('editFirstName').value,
                lastName: document.getElementById('editLastName').value,
                patronymic: document.getElementById('editPatronymic').value,
                dateOfBirth: document.getElementById('editDateOfBirth').value,
                address: document.getElementById('editAddress').value,
                phoneNumber: document.getElementById('editPhoneNumber').value,
                email: document.getElementById('editEmail').value,
                policyNumber: document.getElementById('editPolicyNumber').value,
                snils: document.getElementById('editSnils').value,
                passport: document.getElementById('editPassport').value,
            };

            const token = getAdminToken();
            if (!token) {
                alert('Необходима авторизация администратора.');
                return;
            }

            // Обновление аватара
            await uploadAvatar(patientId);

            // Обновление остальных данных
            try {
                const response = await fetch(`http://localhost:3003/api/admin/patients/data/update/${patientId}`, {
                    method: 'PUT',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(payload),
                });

                if (!response.ok) {
                    throw new Error(`Ошибка HTTP: ${response.status}`);
                }

                const result = await response.json();
                alert(result.message);

                const modal = bootstrap.Modal.getInstance(document.getElementById('editPatientModal'));
                modal.hide();

                loadPatients(); // Обновление списка
            } catch (error) {
                console.error('Ошибка обновления:', error);
                alert('Не удалось обновить данные пациента.');
            }
        });

        document.addEventListener('DOMContentLoaded', () => {
            loadPatients();
        });
    </script>
<script>
    $(document).ready(function(){
        $("#editPhoneNumber").inputmask("+7 (999) 999-99-99");  // Телефон
        $("#editPolicyNumber").inputmask("9999 9999 9999 9999"); // Полис
        $("#editSnils").inputmask("999-999-999 99");  // СНИЛС
        $("#editPassport").inputmask("9999 999999");  // Паспорт
    });
</script>
</body>
</html>
