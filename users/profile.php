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
    <!-- Навигационное меню слева -->
    <?php include 'navbar.php'; ?>

    <!-- Основной контент -->
    <div id="content" class="container mt-5">
        <h2 class="mb-4">Профиль пациента | DentalBook</h2>

        <!-- Карточка профиля -->
        <div class="profile-card mb-4">
            <div class="row align-items-center">
                <!-- Левая колонка: информация о пациенте -->
                <div class="col-md-8">
                    <div class="row mb-3">
                        <div class="col-1 text-center">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="col-11">
                            <strong>ФИО:</strong> Анна Смирнова Валерьевна
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-1 text-center">
                            <i class="fas fa-calendar"></i>
                        </div>
                        <div class="col-11">
                            <strong>Дата рождения:</strong> 12.05.1990
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-1 text-center">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <div class="col-11">
                            <strong>Полис:</strong> 1234 5678 9101 1121
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-1 text-center">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="col-11">
                            <strong>Контактный телефон:</strong> +7 (900) 123-45-67
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-1 text-center">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="col-11">
                            <strong>Email:</strong> anna.smirnova@example.com
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-1 text-center">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="col-11">
                            <strong>Адрес:</strong> г. Москва, ул. Ленина, д. 10, кв. 5
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-1 text-center">
                            <i class="fas fa-sign-in-alt"></i>
                        </div>
                        <div class="col-11">
                            <strong>Последний вход:</strong> 18 декабря 2024, 14:30
                        </div>
                    </div>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                        <span class="fas fa-edit"></span> Редактировать
                    </button>
                </div>

                <!-- Правая колонка: иконка профиля -->
                <div class="col-md-4 text-center">
                    <div class="profile-icon" id="profileImageContainer">
                        <i class="fas fa-user fa-5x"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="actions mb-4">
            <a href="/users/anketa.php" class="btn btn-primary"><i class="fas fa-file-alt"></i> Анкета</a>
            <button class="btn btn-secondary"><i class="fas fa-file-contract"></i> Договор</button>
            <button class="btn btn-info"><i class="fas fa-star"></i> Оценка</button>
            <button class="btn btn-danger"><i class="fas fa-print"></i> Печать</button>
        </div>

        <!-- Модальное окно -->
        <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editProfileLabel">Редактировать профиль</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="firstName" class="form-label">Имя *</label>
                                    <input type="text" class="form-control" id="firstName" placeholder="Введите имя">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="lastName" class="form-label">Фамилия *</label>
                                    <input type="text" class="form-control" id="lastName" placeholder="Введите фамилию">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="patronymic" class="form-label">Отчество</label>
                                    <input type="text" class="form-control" id="patronymic" placeholder="Введите отчество">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="gender" class="form-label">Пол</label>
                                    <select class="form-select" id="gender">
                                        <option value="male" selected>Мужчина</option>
                                        <option value="female">Женщина</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="birthDate" class="form-label">Дата рождения</label>
                                    <input type="date" class="form-control" id="birthDate">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="address" class="form-label">Адрес</label>
                                    <input type="text" class="form-control" id="address" placeholder="Введите адрес">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" placeholder="Введите email">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="phone" class="form-label">Телефон *</label>
                                    <input type="tel" class="form-control" id="phone" placeholder="Введите телефон">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="policy" class="form-label">Полис</label>
                                    <input type="text" class="form-control" id="policy" placeholder="Введите номер полиса">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="snils" class="form-label">СНИЛС</label>
                                    <input type="text" class="form-control" id="snils" placeholder="Введите СНИЛС">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="passport" class="form-label">Паспорт</label>
                                    <input type="text" class="form-control" id="passport" placeholder="Введите данные паспорта">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                            <button type="submit" class="btn btn-primary">Сохранить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

      
        <!-- Tabs -->
        <div class="tabs">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link" href="/users/view.php"><i class="fas fa-calendar-check"></i> Визиты</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/users/formula.php"><i class="fas fa-tooth"></i> Формула</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#payments" data-bs-toggle="tab"><i class="fas fa-dollar-sign"></i> Оплаты</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/users/treatmentplan.php"><i class="fas fa-notes-medical"></i> План лечения</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/users/pictures.php"><i class="fas fa-image"></i> Снимки</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/users/notes.php"><i class="fas fa-sticky-note"></i> Примечания</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#documents" data-bs-toggle="tab"><i class="fas fa-folder"></i> Документы</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#personal-data" data-bs-toggle="tab"><i class="fas fa-id-card"></i> Персональные данные</a>
                </li>
            </ul>
        </div>

    <!-- Подключение скриптов -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        // Получаем текущий URL
        const currentPath = window.location.pathname;

        // Ищем все элементы с классом "nav-link"
        const navLinks = document.querySelectorAll('.nav-tabs .nav-link');

        // Проходим по всем ссылкам и проверяем их href
        navLinks.forEach(link => {
            // Если путь в href совпадает с текущим URL, добавляем класс "active"
            if (link.getAttribute('href') === currentPath) {
                link.classList.add('active');
            } else {
                link.classList.remove('active');
            }
        });
    });
</script>

</body>
</html>