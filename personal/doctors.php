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
<?php include '../adminpanel/navbar.php'; ?>

    <div class="container mt-4">
        <!-- Tabs Navigation -->
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" id="doctors-tab" href="doctors.php">
                    <i class="fas fa-user-md"></i> Доктора
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
                                <th>Специальности</th>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Функция получения токена из cookies
    function getTokenFromCookies() {
        const cookies = document.cookie.split('; ');
        const tokenCookie = cookies.find(row => row.startsWith('token='));
        return tokenCookie ? tokenCookie.split('=')[1] : null;
    }

    // Функция декодирования JWT токена
    function parseJwt(token) {
        try {
            return JSON.parse(atob(token.split('.')[1])); // Декодируем payload токена
        } catch (e) {
            return null;
        }
    }

    // Функция проверки роли пользователя
    function checkUserRole() {
        const token = getTokenFromCookies();

        if (!token) {
            alert('Вы не авторизованы!');
            window.location.href = '/auth.php'; // Перенаправление на страницу авторизации
            return false;
        }

        // Декодируем токен и проверяем роль
        const decodedToken = parseJwt(token);
        const userRole = decodedToken?.role;

        if (userRole !== 'manager') {
            alert('У вас нет доступа к этой странице!');
            window.location.href = '/auth.php'; // Перенаправление на страницу авторизации
            return false;
        }

        return true;
    }

    // Функция загрузки врачей с API
    async function loadDoctors() {
        if (!checkUserRole()) return; // Проверяем роль перед загрузкой данных

        const token = getTokenFromCookies();
        try {
            const response = await fetch('http://localhost:3003/api/doctors/get/all', {
                headers: {
                    'Authorization': `Bearer ${token}`,
                    'Content-Type': 'application/json'
                }
            });

            if (!response.ok) {
                throw new Error('Ошибка загрузки списка докторов');
            }

            const doctors = await response.json();
            const tableBody = document.getElementById('doctorTableBody');

            tableBody.innerHTML = doctors.map(doctor => `
                <tr>
                    <td>${doctor.id}</td>
                    <td><img src="${doctor.avatar}" alt="Аватар" class="avatar-img"></td>
                    <td>${doctor.fullName}</td>
                    <td>${doctor.specialty}</td>
                </tr>
            `).join('');
        } catch (error) {
            console.error('Ошибка загрузки докторов:', error);
            alert('Не удалось загрузить список докторов.');
        }
    }

    // Запуск загрузки врачей после проверки роли
    document.addEventListener('DOMContentLoaded', loadDoctors);
</script>


</body>
</html>
