<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Администраторы приема | DentalBook</title>
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
                <a class="nav-link" id="doctors-tab" href="doctors.php">
                    <i class="fas fa-user-md"></i> Доктора
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" id="managers-tab" href="manager.php">
                    <i class="fas fa-user-tie"></i> Администраторы приема
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="patients-tab" href="patients.php">
                    <i class="fas fa-users"></i> Пациенты
                </a>
            </li>
        </ul>

        <div class="tab-content mt-4">
            <div class="tab-pane fade show active" id="managers">
                <div class="header-section">
                    <h1 class="h4">Список администраторов приема</h1>
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addManagerModal">
                        <i class="fas fa-plus"></i> Добавить администратора
                    </button>
                </div>
                <div class="table-container">
                    <table class="table">
                        <thead class="table-light">
                            <tr>
                                <th>Фото</th>
                                <th>ФИО</th>
                                <th>Email</th>
                                <th>Пол</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody id="managerTableBody">
                            <!-- Данные администраторов -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Модальное окно создания администратора -->
    <div class="modal fade" id="addManagerModal" tabindex="-1" aria-labelledby="addManagerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addManagerModalLabel">Добавить администратора приема</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                </div>
                <div class="modal-body">
                    <form id="addManagerForm">
                        <div class="mb-3">
                            <label for="firstName" class="form-label">Имя:</label>
                            <input type="text" class="form-control" id="firstName" required>
                        </div>
                        <div class="mb-3">
                            <label for="lastName" class="form-label">Фамилия:</label>
                            <input type="text" class="form-control" id="lastName" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" class="form-control" id="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Пароль:</label>
                            <input type="password" class="form-control" id="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="gender" class="form-label">Пол:</label>
                            <select class="form-select" id="gender">
                                <option value="male">Мужской</option>
                                <option value="female">Женский</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Добавить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', async () => {
            const token = getCookie('token');

            async function loadManagers() {
                try {
                    const response = await fetch('http://localhost:3003/api/admin/manager/getall', {
                        headers: { Authorization: `Bearer ${token}` }
                    });

                    if (!response.ok) {
                        throw new Error('Ошибка загрузки списка администраторов приема');
                    }

                    const managers = await response.json();
                    const managerTableBody = document.getElementById('managerTableBody');
                    managerTableBody.innerHTML = managers.map(managerToHTML).join('');
                } catch (error) {
                    console.error('Ошибка загрузки администраторов:', error);
                    alert('Не удалось загрузить список администраторов.');
                }
            }

            function managerToHTML(manager) {
                return `
                    <tr>
                        <td>
                            <img src="${manager.avatar || '/backend/uploads/avatars/default_avatar.png'}" alt="Аватар" class="avatar-img">
                        </td>
                        <td>${manager.lastName} ${manager.firstName}</td>
                        <td>${manager.email}</td>
                        <td>${manager.gender === 'male' ? 'Мужской' : 'Женский'}</td>
                        <td>
                            <button class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </button>
                        </td>
                    </tr>
                `;
            }

            async function addManager(event) {
                event.preventDefault();
                const managerData = {
                    firstName: document.getElementById('firstName').value,
                    lastName: document.getElementById('lastName').value,
                    email: document.getElementById('email').value,
                    password: document.getElementById('password').value,
                    gender: document.getElementById('gender').value
                };

                try {
                    const response = await fetch('http://localhost:3003/api/admin/manager/create', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            Authorization: `Bearer ${token}`
                        },
                        body: JSON.stringify(managerData)
                    });

                    if (!response.ok) throw new Error('Ошибка при создании администратора.');

                    const result = await response.json();
                    alert(result.message);
                    bootstrap.Modal.getInstance(document.getElementById('addManagerModal')).hide();
                    await loadManagers();
                } catch (error) {
                    console.error('Ошибка создания:', error);
                    alert('Не удалось создать администратора.');
                }
            }

            document.getElementById('addManagerForm').addEventListener('submit', addManager);

            await loadManagers();
        });

        function getCookie(name) {
            const value = `; ${document.cookie}`;
            const parts = value.split(`; ${name}=`);
            if (parts.length === 2) return parts.pop().split(';').shift();
        }
    </script>
</body>
</html>
