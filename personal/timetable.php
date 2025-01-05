<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Профиль доктора | DentalBook</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
        }

        #content {
            margin-left: 270px;
            padding: 20px;
            background-color: #f4f6f9;
            min-height: 100vh;
        }

        .header h2 {
            margin: 0;
            font-size: 1.8rem;
            color: #343a40;
            border-bottom: 2px solid #ddd;
            padding-bottom: 10px;
            margin-bottom: 20px;
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
            margin-top: 20px;
        }

        .table-container table {
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
        }
    </style>
</head>
<body>
    <?php include '../users/navbar.php'; ?>

    <div id="content" class="container mt-5">
        <h2 class="mb-4">Профиль доктора | DentalBook</h2>

        <!-- Doctor Profile Section -->
        <div class="profile-card mb-4">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="row mb-3">
                        <div class="col-1 text-center">
                            <i class="fas fa-user-md"></i>
                        </div>
                        <div class="col-11">
                            <strong>ФИО:</strong> Иванов Иван Иванович
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-1 text-center">
                            <i class="fas fa-calendar"></i>
                        </div>
                        <div class="col-11">
                            <strong>Дата рождения:</strong> 12.08.1971
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-1 text-center">
                            <i class="fas fa-user-md"></i>
                        </div>
                        <div class="col-11">
                            <strong>Специальность:</strong> Терапевт, Ортодонт
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-1 text-center">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="col-11">
                            <strong>Контактный телефон:</strong> <a href="tel:+79261234567">+7 (926) 123-45-67</a>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-1 text-center">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="col-11">
                            <strong>Email:</strong> <a href="mailto:korvovka@gmail.com">korvovka@gmail.com</a>
                        </div>
                    </div>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editDoctorModal">
                        <i class="fas fa-edit"></i> Редактировать
                    </button>
                </div>
                <div class="col-md-4 text-center">
                    <div class="profile-icon">
                        <i class="fas fa-user-md fa-5x"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs Section -->
        <div class="tabs">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" href="#schedule" data-bs-toggle="tab"><i class="fas fa-calendar-alt"></i> Расписание</a>
                </li>
            </ul>
            <div class="tab-content mt-3">
                <!-- Schedule Tab -->
                <div class="tab-pane fade show active" id="schedule">
                    <div class="table-container">
                        <table class="table table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th>Дата</th>
                                    <th>Время</th>
                                    <th>Пациент</th>
                                    <th>Тип визита</th>
                                    <th>Статус</th>
                                    <th>Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>25.12.2024</td>
                                    <td>09:00</td>
                                    <td><a href="patient_profile.php?id=1">Иванов Иван</a></td>
                                    <td>Консультация</td>
                                    <td><span class="badge bg-success">Подтвержден</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-info" title="Просмотр"><i class="fas fa-eye"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>25.12.2024</td>
                                    <td>10:30</td>
                                    <td><a href="patient_profile.php?id=2">Смирнова Анна</a></td>
                                    <td>Лечение</td>
                                    <td><span class="badge bg-warning text-dark">Ожидает</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-info" title="Просмотр"><i class="fas fa-eye"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>25.12.2024</td>
                                    <td>12:00</td>
                                    <td><a href="patient_profile.php?id=3">Петров Дмитрий</a></td>
                                    <td>Удаление</td>
                                    <td><span class="badge bg-danger">Отменено</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-info" title="Просмотр"><i class="fas fa-eye"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>25.12.2024</td>
                                    <td>14:00</td>
                                    <td><a href="patient_profile.php?id=4">Кузнецова Мария</a></td>
                                    <td>Протезирование</td>
                                    <td><span class="badge bg-success">Подтвержден</span></td>
                                    <td>
                                        <button class="btn btn-sm btn-info" title="Просмотр"><i class="fas fa-eye"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Editing Doctor -->
    <div class="modal fade" id="editDoctorModal" tabindex="-1" aria-labelledby="editDoctorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editDoctorModalLabel">Редактировать профиль доктора</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="doctorFirstName" class="form-label">Имя</label>
                                <input type="text" class="form-control" id="doctorFirstName" placeholder="Введите имя">
                            </div>
                            <div class="col-md-4">
                                <label for="doctorLastName" class="form-label">Фамилия</label>
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
                                    <option value="male">Мужской</option>
                                    <option value="female">Женский</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="doctorBirthDate" class="form-label">Дата рождения</label>
                                <input type="date" class="form-control" id="doctorBirthDate">
                            </div>
                            <div class="col-md-4">
                                <label for="doctorEmail" class="form-label">Email</label>
                                <input type="email" class="form-control" id="doctorEmail" placeholder="Введите email">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="doctorPhone" class="form-label">Телефон</label>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
