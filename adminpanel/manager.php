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
                <a class="nav-link active" id="patients-tab" href="manager.php">
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
                                <th>Email</th>
                                <th>Телефон</th>
                                <th>Дата рождения</th>
                                <th>Специальности</th>
                                <th>Действия</th>
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

    <!-- Modal -->
    <div class="modal fade" id="editDoctorModal" tabindex="-1" aria-labelledby="editDoctorModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editDoctorModalLabel">Редактировать профиль доктора</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editDoctorForm">
                        <input type="hidden" id="editDoctorId">

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="editFirstName" class="form-label">Имя:</label>
                                <input type="text" class="form-control" id="editFirstName" required>
                            </div>
                            <div class="col-md-6">
                                <label for="editLastName" class="form-label">Фамилия:</label>
                                <input type="text" class="form-control" id="editLastName" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="editPatronymic" class="form-label">Отчество:</label>
                                <input type="text" class="form-control" id="editPatronymic">
                            </div>
                            <div class="col-md-6">
                                <label for="editDateOfBirth" class="form-label">Дата рождения:</label>
                                <input type="date" class="form-control" id="editDateOfBirth" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="editEmail" class="form-label">Email:</label>
                                <input type="email" class="form-control" id="editEmail" required>
                            </div>
                            <div class="col-md-6">
                                <label for="editMobilePhone" class="form-label">Телефон:</label>
                                <input type="text" class="form-control" id="editMobilePhone" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="editSpecialty" class="form-label">Специальность:</label>
                                <input type="text" class="form-control" id="editSpecialty" required>
                            </div>
                        </div>

                        <!-- Загрузка аватара -->
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="editAvatar" class="form-label">Обновить аватар:</label>
                                <input type="file" class="form-control" id="editAvatar">
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Отмена</button>
                            <button type="submit" class="btn btn-primary">Сохранить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>