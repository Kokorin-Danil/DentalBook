<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Пациенты | DentalBook</title>
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

        /* Таблица пациентов */
        .table-actions button {
            margin-right: 5px;
        }

        .search-bar {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .search-bar input {
            flex: 1;
            margin-right: 10px;
        }

        .search-bar .fa-search {
            position: relative;
            left: -30px;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <!-- Навигационное меню -->
    <?php include 'navbar.php'; ?>

    <!-- Основной контент -->
    <div id="content">
        <div class="container mt-5">
            <h2 class="mb-4">Пациенты</h2>

            <!-- Поиск -->
            <div class="search-bar">
                <input type="text" class="form-control" placeholder="Поиск по ФИО">
                <i class="fas fa-search"></i>
                <button class="btn btn-secondary ms-2"><i class="fas fa-filter"></i> Фильтр</button>
                <a href="/users/createcardpatient.php" class="btn btn-success ms-2"><i class="fas fa-plus"></i> Добавить пациента</a>
            </div>
            
            <!-- Таблица пациентов -->
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Номер карты</th>
                        <th>ФИО</th>
                        <th>Телефон</th>
                        <th>Последний визит</th>
                        <th>Статус</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>2</td>
                        <td>Анна Смирнова Валерьевна</td>
                        <td>+7 900 123 45 67</td>
                        <td>15.12.2024, 15:20</td>
                        <td>Активный</td>
                        <td class="table-actions">
                            <a href="/users/view.php" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i> Просмотреть
                            </a>
                            <button class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> Редактировать</button>
                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Удалить</button>
                        </td>
                    </tr>
                    <!-- Другие пациенты -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Модальное окно -->
    <div class="modal fade" id="patientModal" tabindex="-1" aria-labelledby="patientModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="patientModalLabel">Информация о пациенте</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>ФИО:</strong> Иванов Иван Иванович</p>
                    <p><strong>Номер карты:</strong> 12345</p>
                    <p><strong>Телефон:</strong> +7 900 123 45 67</p>
                    <p><strong>Последний визит:</strong> 15.12.2024</p>
                    <p><strong>Статус:</strong> Активный</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function logout() {
            if (confirm('Вы уверены, что хотите выйти из системы?')) {
                location.href = '/logout';
            }
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
