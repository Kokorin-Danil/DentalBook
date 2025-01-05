<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Персонал - Администраторы</title>
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
        .btn-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            padding: 0;
            font-size: 14px;
        }
        .action-buttons .btn {
            margin-right: 5px;
        }
        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        .filters {
            margin-bottom: 10px;
        }
        .filters .form-control,
        .filters .form-select {
            border-radius: 5px;
        }
        h1.h4 {
            margin-bottom: 10px;
        }
        table {
            margin-bottom: 0;
        }
    </style>
</head>
<body>
    <?php include '../personal/personal.php'; ?>
    <div class="container mt-4">
        <!-- Header Section -->
        <div class="header-section">
            <h1 class="h4">Список администраторов</h1>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAdminModal"><i class="fas fa-plus"></i> Добавить</button>
        </div>

        <!-- Filters Section -->
        <div class="filters">
            <form class="row g-2">
                <div class="col-md-3">
                    <input type="text" class="form-control" placeholder="Поиск по ФИО">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-search"></i> Искать</button>
                </div>
            </form>
        </div>

        <!-- Table Section -->
        <div class="table-container">
            <table class="table table-striped">
                <thead class="table-light">
                    <tr>
                        <th>Id</th>
                        <th>ФИО</th>
                        <th>Email</th>
                        <th>Телефон</th>
                        <th>Должность</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1023456</td>
                        <td>Кузнецов Михаил Андреевич</td>
                        <td>m.kuznetsov@clinic.ru</td>
                        <td><a href="tel:+79112345678">+7 (911) 123-45-67</a></td>
                        <td>Старший администратор</td>
                        <td class="action-buttons">
                            <button class="btn btn-sm btn-info" title="Просмотр"><i class="fas fa-eye"></i></button>
                            <button class="btn btn-sm btn-warning" title="Редактировать"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-sm btn-danger" title="Удалить"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>1025678</td>
                        <td>Иванова Анастасия Сергеевна</td>
                        <td>a.ivanova@clinic.ru</td>
                        <td><a href="tel:+79261234567">+7 (926) 123-45-67</a></td>
                        <td>Администратор</td>
                        <td class="action-buttons">
                            <button class="btn btn-sm btn-info" title="Просмотр"><i class="fas fa-eye"></i></button>
                            <button class="btn btn-sm btn-warning" title="Редактировать"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-sm btn-danger" title="Удалить"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal for Adding Administrator -->
    <div class="modal fade" id="addAdminModal" tabindex="-1" aria-labelledby="addAdminModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAdminModalLabel">Добавить</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="adminFirstName" class="form-label">Имя</label>
                                <input type="text" class="form-control" id="adminFirstName" placeholder="Введите имя">
                            </div>
                            <div class="col-md-4">
                                <label for="adminLastName" class="form-label">Фамилия</label>
                                <input type="text" class="form-control" id="adminLastName" placeholder="Введите фамилию">
                            </div>
                            <div class="col-md-4">
                                <label for="adminPatronymic" class="form-label">Отчество</label>
                                <input type="text" class="form-control" id="adminPatronymic" placeholder="Введите отчество">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="adminGender" class="form-label">Пол</label>
                                <select class="form-select" id="adminGender">
                                    <option value="" selected>Выберите пол</option>
                                    <option value="male">Мужской</option>
                                    <option value="female">Женский</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="adminBirthDate" class="form-label">Дата рождения</label>
                                <input type="date" class="form-control" id="adminBirthDate">
                            </div>
                            <div class="col-md-4">
                                <label for="adminEmail" class="form-label">Email</label>
                                <input type="email" class="form-control" id="adminEmail" placeholder="Введите email">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="adminPhone" class="form-label">Телефон</label>
                                <input type="tel" class="form-control" id="adminPhone" placeholder="Введите телефон">
                            </div>
                            <div class="col-md-6">
                                <label for="adminPhoto" class="form-label">Фото</label>
                                <input type="file" class="form-control" id="adminPhoto" accept="image/jpeg,image/png">
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
</body>
</html>
