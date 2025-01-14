<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Профиль пациента | DentalBook</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="ccs/style.css" rel="stylesheet">
    <style>
        /* Стили навигационного меню */
        #sidebar {
            width: 250px;
            background-color: #f8f9fa;
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
        </style>
</head>
<body>
    <!-- Навигационное меню слева -->
    <nav id="sidebar">
        <h4>DentalBook</h4>
        <ul class="list-unstyled">
            <li><a href="/index.php"><i class="fas fa-home"></i> Главная</a></li>
            <li><a href="#"><i class="fas fa-tachometer-alt"></i> Панель управления</a></li>
            <li><a href="/personal/profiledoctor.php"><i class="fas fa-user"></i> Мой профиль</a></li>
            <li><a href="/users/createcardpatient.php"><i class="fas fa-address-card"></i> Создать карту</a></li>
            <li><a href="/inspection/initial.php"><i class="fas fa-clipboard-check"></i> Лист осмотра</a></li>
            <li><a href="/users/patients.php"><i class="fas fa-users"></i> Пациенты</a></li>
            <li><a href="/personal/doctors.php"><i class="fas fa-users"></i> Персонал</a></li>
            <li><a href="/kalendar/kalendar.php"><i class="fas fa-calendar-alt"></i> Записи</a></li>
            <li><a href="#"><i class="fas fa-folder-open"></i> Карты пациентов</a></li>
            <li><a href="#"><i class="fas fa-chart-bar"></i> Статистика</a></li>
            <li><a href="#"><i class="fas fa-cogs"></i> Настройки</a></li>
            <li><a href="#" onclick="logout()"><i class="fas fa-sign-out-alt"></i> Выйти</a></li>
        </ul>
    </nav>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
</body>
</html>