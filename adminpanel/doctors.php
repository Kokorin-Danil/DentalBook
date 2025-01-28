<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Доктора</title>
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
                <a class="nav-link active" id="doctors-tab" href="doctors.php">
                    <i class="fas fa-user-md"></i> Доктора
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="patients-tab" href="patients.php">
                    <i class="fas fa-users"></i> Пациенты
                </a>
            </li>
        </ul>

        <div class="tab-content mt-4">
            <!-- Doctors Tab -->
            <div class="tab-pane fade show active" id="doctors">
                <div class="header-section">
                    <h1 class="h4">Список докторов</h1>
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
                                <th>Специальности</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody id="doctorTableBody">
                            <!-- Данные докторов -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="editDoctorModal" tabindex="-1" aria-labelledby="editDoctorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editDoctorModalLabel">Редактировать профиль доктора</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editDoctorForm">
                        <input type="hidden" id="editDoctorId">

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
                                <label for="editDateOfBirth" class="form-label">Дата рождения:</label>
                                <input type="date" class="form-control" id="editDateOfBirth" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="editEmail" class="form-label">Email:</label>
                                <input type="email" class="form-control" id="editEmail" required>
                            </div>
                            <div class="col-md-6">
                                <label for="editMobilePhone" class="form-label">Телефон:</label>
                                <input type="text" class="form-control" id="editMobilePhone" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="editSpecialty" class="form-label">Специальность:</label>
                                <input type="text" class="form-control" id="editSpecialty" required>
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

        async function loadDoctors() {
            const data = await fetchData('http://localhost:3003/api/admin/doctors/get');
            if (!data || !data.doctors) return;

            const doctorTableBody = document.getElementById('doctorTableBody');
            doctorTableBody.innerHTML = data.doctors.map(doctor => `
                <tr>
                    <td>${doctor.doctorId}</td>
                    <td>
                        <img src="${doctor.avatar || '/backend/uploads/avatars/default_avatar.png'}" alt="Аватар" class="avatar-img">
                    </td>
                    <td>${doctor.lastName} ${doctor.firstName} ${doctor.patronymic}</td>
                    <td>${doctor.email}</td>
                    <td>${doctor.mobilePhone}</td>
                    <td>${doctor.dateOfBirth}</td>
                    <td>${doctor.specialty}</td>
                    <td class="action-buttons">
                        <a href="/personal/profiledoctorbyid.php?doctorId=${doctor.doctorId}" class="btn btn-sm btn-info">
                            <i class="fas fa-eye"></i>
                        </a>
                        <button class="btn btn-sm btn-warning" onclick="openEditModal(${doctor.doctorId}, ${JSON.stringify(doctor).replace(/"/g, '&quot;')})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger" onclick="deleteDoctor(${doctor.doctorId})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `).join('');
        }

        function openEditModal(doctorId, doctor) {
            document.getElementById('editDoctorId').value = doctorId;
            document.getElementById('editFirstName').value = doctor.firstName || '';
            document.getElementById('editLastName').value = doctor.lastName || '';
            document.getElementById('editPatronymic').value = doctor.patronymic || '';
            document.getElementById('editDateOfBirth').value = doctor.dateOfBirth || '';
            document.getElementById('editEmail').value = doctor.email || '';
            document.getElementById('editMobilePhone').value = doctor.mobilePhone || '';
            document.getElementById('editSpecialty').value = doctor.specialty || '';

            const modal = new bootstrap.Modal(document.getElementById('editDoctorModal'));
            modal.show();
        }

        async function uploadAvatar(doctorId) {
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
                const response = await fetch(`http://localhost:3003/api/admin/doctors/avatar/update/${doctorId}`, {
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
                return result.avatar;
            } catch (error) {
                console.error('Ошибка обновления аватара:', error);
                alert('Не удалось обновить аватар.');
                return null;
            }
        }

        async function deleteDoctor(doctorId) {
            const token = getAdminToken();
            if (!token) {
                alert('Необходима авторизация администратора.');
                return;
            }

            if (!confirm('Вы уверены, что хотите удалить этого доктора?')) return;

            try {
                const response = await fetch(`http://localhost:3003/api/admin/doctors/delete/${doctorId}`, {
                    method: 'DELETE',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Content-Type': 'application/json',
                    },
                });

                if (!response.ok) {
                    throw new Error(`Ошибка HTTP: ${response.status}`);
                }

                alert('Доктор успешно удален.');
                loadDoctors();
            } catch (error) {
                console.error('Ошибка удаления:', error);
                alert('Не удалось удалить доктора.');
            }
        }

        document.getElementById('editDoctorForm').addEventListener('submit', async (event) => {
            event.preventDefault();

            const doctorId = document.getElementById('editDoctorId').value;
            const payload = {
                firstName: document.getElementById('editFirstName').value,
                lastName: document.getElementById('editLastName').value,
                patronymic: document.getElementById('editPatronymic').value,
                dateOfBirth: document.getElementById('editDateOfBirth').value,
                email: document.getElementById('editEmail').value,
                mobilePhone: document.getElementById('editMobilePhone').value,
                specialty: document.getElementById('editSpecialty').value,
            };

            const token = getAdminToken();
            if (!token) {
                alert('Необходима авторизация администратора.');
                return;
            }

            // Обновление аватара
            await uploadAvatar(doctorId);

            // Обновление остальных данных
            try {
                const response = await fetch(`http://localhost:3003/api/admin/doctors/data/update/${doctorId}`, {
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

                const modal = bootstrap.Modal.getInstance(document.getElementById('editDoctorModal'));
                modal.hide();

                loadDoctors();
            } catch (error) {
                console.error('Ошибка обновления:', error);
                alert('Не удалось обновить данные доктора.');
            }
        });

        document.addEventListener('DOMContentLoaded', () => {
            loadDoctors();
        });
    </script>
</body>
</html>
