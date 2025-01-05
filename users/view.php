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

        /* Контент страницы */
        #content {
            margin-left: 270px;
            padding: 20px;
            background-color: #f4f6f9;
            min-height: 100vh;
        }

        body {
            background-color: #f4f6f9;
        }

        .header h2 {
            margin: 0;
            font-size: 1.8rem;
            color: #343a40;
            border-bottom: 2px solid #ddd;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .patient-info {
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .tabs {
            margin-bottom: 20px;
        }

        .tabs .nav-tabs .nav-link {
            color: #495057;
            margin-right: 5px;
            border-radius: 5px;
        }

        .tabs .nav-tabs .nav-link.active {
            color: #ffffff;
            background-color: #007bff;
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

        .profile-card {
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .profile-icon {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 150px;
            width: 150px;
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 50%;
            margin: auto;
        }

        .actions button {
            margin-right: 10px;
        }

        .modal-content {
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .btn-primary {
            background: linear-gradient(45deg, #007bff, #0056b3);
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(45deg, #0056b3, #003f88);
        }
    </style>
</head>
<body>
    <?php include 'profile.php'; ?>
         <!-- Tab Content -->
         <div class="tab-content">
            <!-- Визиты -->
            <div class="tab-pane fade show active" id="visits">
                <div class="table-container">
                <!-- Кнопка для открытия модального окна -->
                <button class="btn btn-primary btn-add" data-bs-toggle="modal" data-bs-target="#addVisitModal">Добавить визит</button>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Визит</th>
                                <th>Тип</th>
                                <th>Статус</th>
                                <th>Зубы</th>
                                <th>Цена</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>2094208</td>
                                <td>11.06.2021, 15:20</td>
                                <td>Лечение</td>
                                <td>Не подтвержден</td>
                                <td>-</td>
                                <td>-</td>
                                <td>
                                    <button class="btn btn-sm btn-info"><i class="fas fa-eye"></i></button>
                                    <button class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                </td>
                            </tr>
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
                            <form>
                                <!-- ФИО пациента -->
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label for="patientName" class="form-label">ФИО пациента</label>
                                        <input type="text" id="patientName" class="form-control" placeholder="Введите ФИО пациента">
                                    </div>
                                </div>

                                <!-- Тип записи и врач -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="visitType" class="form-label">Тип записи</label>
                                        <select id="visitType" class="form-select">
                                            <option selected>Лечение</option>
                                            <option>Осмотр</option>
                                            <option>Консультация</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="doctor" class="form-label">Врач</label>
                                        <select id="doctor" class="form-select">
                                            <option selected>Не выбран</option>
                                            <option>Иванов Иван</option>
                                            <option>Петров Петр</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Дата и время визита -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="visitDate" class="form-label">Дата визита</label>
                                        <input type="date" id="visitDate" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="visitTime" class="form-label">Время визита</label>
                                        <input type="time" id="visitTime" class="form-control">
                                    </div>
                                </div>

                                <!-- Статус -->
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label for="status" class="form-label">Статус</label>
                                        <select id="status" class="form-select">
                                            <option selected>Не подтверждена</option>
                                            <option>Подтверждена</option>
                                            <option>Отменена</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                        
                        <!-- Подвал модального окна -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                            <button type="button" class="btn btn-primary">Сохранить</button>
                        </div>
                    </div>
                </div>
            </div>



    <!-- Подключение скриптов -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
