<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Персонал - Доктора</title>
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
            <h1 class="h4">Список докторов</h1>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addDoctorModal"><i class="fas fa-plus"></i> Добавить</button>
        </div>

        <!-- Filters Section -->
        <div class="filters">
            <form class="row g-2">
                <div class="col-md-3">
                    <input type="text" class="form-control" placeholder="Поиск по ФИО">
                </div>
                <div class="col-md-3">
                    <select class="form-select">
                        <option selected>Выберите специальность</option>
                        <option value="1">Терапевт</option>
                        <option value="2">Хирург</option>
                        <option value="3">Ортодонт</option>
                    </select>
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
                        <th>Специальность</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1037474</td>
                        <td>Визькин Илья Петрович</td>
                        <td>support@mail.ru</td>
                        <td>+7 (926) 123-45-67</td>
                        <td>Терапевт, Ортодонт</td>
                        <td class="action-buttons">
                        <a href="/personal/profiledoctor.php" class="btn btn-sm btn-info" title="Просмотр">
                            <i class="fas fa-eye"></i>
                        </a>
                            <button class="btn btn-sm btn-warning" title="Редактировать"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-sm btn-danger" title="Удалить"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>564229</td>
                        <td>Иванов Иван Иванович</td>
                        <td>korvovka@gmail.com</td>
                        <td>+7 (926) 123-45-67</td>
                        <td>Хирург, Ортопед</td>
                        <td class="action-buttons">
                        <a href="doctor_profile.php" class="btn btn-sm btn-info" title="Просмотр">
                            <i class="fas fa-eye"></i>
                        </a>
                            <button class="btn btn-sm btn-warning" title="Редактировать"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-sm btn-danger" title="Удалить"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>2991685</td>
                        <td>Петров Петр</td>
                        <td>hjkgghujgh@mf1.ru</td>
                        <td>+7 (926) 123-45-67</td>
                        <td>Терапевт, Хирург, Стоматолог</td>
                        <td class="action-buttons">
                            <button class="btn btn-sm btn-info" title="Просмотр"><i class="fas fa-eye"></i></button>
                            <button class="btn btn-sm btn-warning" title="Редактировать"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-sm btn-danger" title="Удалить"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>232073</td>
                        <td>Стоянов Дмитрий Алексеевич</td>
                        <td>rimma@fkids.kz</td>
                        <td>+7 (926) 123-45-67</td>
                        <td>Ортодонт</td>
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

    <!-- Modal for Adding Doctor -->
    <div class="modal fade" id="addDoctorModal" tabindex="-1" aria-labelledby="addDoctorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addDoctorModalLabel">Добавить доктора</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="doctorFirstName" class="form-label">Имя *</label>
                                <input type="text" class="form-control" id="doctorFirstName" placeholder="Введите имя">
                            </div>
                            <div class="col-md-4">
                                <label for="doctorLastName" class="form-label">Фамилия *</label>
                                <input type="text" class="form-control" id="doctorLastName" placeholder="Введите фамилию">
                            </div>
                            <div class="col-md-4">
                                <label for="doctorPatronymic" class="form-label">Отчество</label>
                                <input type="text" class="form-control" id="doctorPatronymic" placeholder="Введите отчество">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="doctorGender" class="form-label">Пол</label>
                                <select class="form-select" id="doctorGender">
                                    <option value="" selected>Выберите пол</option>
                                    <option value="male">Мужской</option>
                                    <option value="female">Женский</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="doctorBirthDate" class="form-label">Дата рождения</label>
                                <input type="date" class="form-control" id="doctorBirthDate">
                            </div>
                            <div class="col-md-4">
                                <label for="doctorEmail" class="form-label">Email *</label>
                                <input type="email" class="form-control" id="doctorEmail" placeholder="Введите email">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="doctorPhone" class="form-label">Телефон *</label>
                                <input type="tel" class="form-control" id="doctorPhone" placeholder="Введите телефон">
                            </div>
                            <div class="col-md-6">
                                <label for="doctorPhoto" class="form-label">Фото</label>
                                <input type="file" class="form-control" id="doctorPhoto" accept="image/jpeg,image/png">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="doctorSpecialties" class="form-label">Специальности</label>
                                <div class="row">
                                    <div class="col-md-4">
                                        <select class="form-select mb-2">
                                            <option value="" selected>-</option>
                                            <option value="therapist">Терапевт</option>
                                            <option value="surgeon">Хирург</option>
                                            <option value="orthodontist">Ортодонт</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <select class="form-select mb-2">
                                            <option value="" selected>-</option>
                                            <option value="therapist">Терапевт</option>
                                            <option value="surgeon">Хирург</option>
                                            <option value="orthodontist">Ортодонт</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <select class="form-select">
                                            <option value="" selected>-</option>
                                            <option value="therapist">Терапевт</option>
                                            <option value="surgeon">Хирург</option>
                                            <option value="orthodontist">Ортодонт</option>
                                        </select>
                                    </div>
                                </div>
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
