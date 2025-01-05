<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Администратор | DentalBook</title>
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

        /* Контент страницы */
        #content {
            margin-left: 270px;
            padding: 20px;
            background-color: #f8f9fa;
            min-height: 100vh;
        }

        /* Карточки управления */
        .card {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <!-- Навигационное меню слева -->
    <nav id="sidebar">
        <h4>DentalBook</h4>
        <ul class="list-unstyled">
            <li><a href="#"><i class="fas fa-tachometer-alt"></i> Панель управления</a></li>
            <li><a href="#"><i class="fas fa-users"></i> Пользователи</a></li>
            <li><a href="/users/patients.php"><i class="fas fa-users"></i> Пациенты</a></li>
            <li><a href="/personal/personal.php"><i class="fas fa-users"></i> Персонал</a></li>
            <li><a href="#"><i class="fas fa-calendar-alt"></i> Записи</a></li>
            <li><a href="#"><i class="fas fa-folder-open"></i> Карты пациентов</a></li>
            <li><a href="#"><i class="fas fa-chart-bar"></i> Статистика</a></li>
            <li><a href="#"><i class="fas fa-cogs"></i> Настройки</a></li>
            <li><a href="#" onclick="logout()"><i class="fas fa-sign-out-alt"></i> Выйти</a></li>
        </ul>
    </nav>

    <!-- Основной контент -->
    <div id="content">
        <div class="container mt-5">
            <h2 class="mb-4">Панель администратора</h2>

            <div class="row g-4">
                <!-- Управление пользователями -->
                <div class="col-md-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-users fa-2x text-primary"></i></h5>
                            <p class="card-text">Управление пользователями</p>
                            <a href="#" class="btn btn-primary">Перейти</a>
                        </div>
                    </div>
                </div>

                <!-- Управление записями -->
                <div class="col-md-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-calendar-alt fa-2x text-success"></i></h5>
                            <p class="card-text">Управление записями</p>
                            <a href="#" class="btn btn-success">Перейти</a>
                        </div>
                    </div>
                </div>

                <!-- Управление картами пациентов -->
                <div class="col-md-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-folder-open fa-2x text-warning"></i></h5>
                            <p class="card-text">Карты пациентов</p>
                            <a href="#" class="btn btn-warning">Перейти</a>
                        </div>
                    </div>
                </div>

                <!-- Логи действий -->
                <div class="col-md-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-history fa-2x text-info"></i></h5>
                            <p class="card-text">Журнал действий</p>
                            <a href="#" class="btn btn-info">Перейти</a>
                        </div>
                    </div>
                </div>

                <!-- Статистика -->
                <div class="col-md-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-chart-bar fa-2x text-secondary"></i></h5>
                            <p class="card-text">Статистика</p>
                            <a href="#" class="btn btn-secondary">Перейти</a>
                        </div>
                    </div>
                </div>

                <!-- Настройки -->
                <div class="col-md-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-cogs fa-2x text-dark"></i></h5>
                            <p class="card-text">Настройки</p>
                            <a href="#" class="btn btn-dark">Перейти</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Логика выхода из системы
        function logout() {
            if (confirm('Вы уверены, что хотите выйти из системы?')) {
                location.href = '/logout';
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
</body>
</html>
