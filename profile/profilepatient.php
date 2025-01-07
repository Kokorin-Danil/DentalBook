<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Профиль пациента | DentalBook</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        /* Стили навигационного меню */
        #sidebar {
            width: 250px;
            background-color: #ffffff;
            padding: 20px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            overflow-y: auto;
            border-right: 1px solid #ddd;
            box-shadow: 2px 0 8px rgba(0, 0, 0, 0.05);
        }

        #sidebar h4 {
            font-weight: bold;
            color: #007bff;
            text-align: center;
            margin-bottom: 1.5rem;
        }

        #sidebar a {
            font-size: 1rem;
            color: #495057;
            display: flex;
            align-items: center;
            text-decoration: none;
            margin-bottom: 15px;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }

        #sidebar a:hover {
            background-color: #e9ecef;
            color: #007bff;
        }

        #sidebar a i {
            font-size: 1.2rem;
            margin-right: 10px;
        }

        #content {
            margin-left: 270px;
            padding: 20px;
            background-color: #f8f9fa;
            min-height: 100vh;
        }

        .profile-card {
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .profile-icon {
            width: 150px;
            height: 150px;
            background-color: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin: 0 auto;
            overflow: hidden;
        }

        .profile-icon img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <!-- Навигационное меню слева -->
    <nav id="sidebar">
        <h4>DentalBook</h4>
        <ul class="list-unstyled">
            <li><a href="profilepatient.php"><i class="fas fa-user"></i> Мой профиль</a></li>
            <li><a href="/appointments.php"><i class="fas fa-calendar-alt"></i> Мои записи</a></li>
            <li><a href="/cardpatient/cardpatient.php"><i class="fas fa-folder-open"></i> Моя карта</a></li>
            <li><a href="/history.php"><i class="fas fa-history"></i> История посещений</a></li>
            <li><a href="#" onclick="logout()"><i class="fas fa-sign-out-alt"></i> Выйти</a></li>
        </ul>
    </nav>

    <!-- Основной контент -->
    <div id="content">
        <div class="container mt-5">
            <h2 class="mb-4">Профиль пациента | DentalBook</h2>
            
            <!-- Карточка профиля -->
            <div class="profile-card">
                <div class="row align-items-center">
                    <!-- Левая колонка: информация о пациенте -->
                    <div class="col-md-8" id="profileInfo">
                        <div>Загрузка данных...</div>
                    </div>

                    <!-- Правая колонка: иконка профиля -->
                    <div class="col-md-4 text-center">
                        <div class="profile-icon">
                            <i class="fas fa-user fa-5x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Функция для получения токена из cookies
        function getCookie(name) {
            const value = `; ${document.cookie}`;
            const parts = value.split(`; ${name}=`);
            if (parts.length === 2) return parts.pop().split(';').shift();
        }

        const token = getCookie('token');

        if (!token) {
            alert('Вы не авторизованы. Пожалуйста, выполните вход.');
            window.location.href = '/auth.php';
        }

        // Функция для загрузки данных профиля
        async function loadUserProfile() {
            try {
                const response = await fetch('http://localhost:3003/api/users/profile', {
                    method: 'GET',
                    headers: {
                        'Authorization': `Bearer ${token}`
                    }
                });

                if (!response.ok) {
                    throw new Error('Не удалось загрузить профиль');
                }

                const data = await response.json();
                const profile = data.profile;

                // Обновление информации на странице
                const profileInfo = `
                    <div class="row mb-3">
                        <div class="col-1 text-center"><i class="fas fa-user"></i></div>
                        <div class="col-11"><strong>ФИО:</strong> ${profile.fullName}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-1 text-center"><i class="fas fa-calendar"></i></div>
                        <div class="col-11"><strong>Дата рождения:</strong> ${profile.dateOfBirth}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-1 text-center"><i class="fas fa-file-alt"></i></div>
                        <div class="col-11"><strong>Полис:</strong> ${profile.policy}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-1 text-center"><i class="fas fa-phone"></i></div>
                        <div class="col-11"><strong>Контактный телефон:</strong> ${profile.phoneNumber}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-1 text-center"><i class="fas fa-envelope"></i></div>
                        <div class="col-11"><strong>Email:</strong> ${profile.email}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-1 text-center"><i class="fas fa-map-marker-alt"></i></div>
                        <div class="col-11"><strong>Адрес:</strong> ${profile.address}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-1 text-center"><i class="fas fa-sign-in-alt"></i></div>
                        <div class="col-11"><strong>Последний вход:</strong> ${profile.lastLogin}</div>
                    </div>
                `;

                document.getElementById('profileInfo').innerHTML = profileInfo;
            } catch (error) {
                console.error('Ошибка загрузки профиля:', error);
                alert('Не удалось загрузить данные профиля.');
            }
        }

        // Логика выхода из системы
        function logout() {
            if (confirm('Вы уверены, что хотите выйти из системы?')) {
                document.cookie = 'token=; path=/; expires=Thu, 01 Jan 1970 00:00:00 GMT';
                window.location.href = '/auth.php';
            }
        }

        // Загрузка данных профиля при загрузке страницы
        loadUserProfile();
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
