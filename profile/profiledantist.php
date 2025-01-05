<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Профиль стоматолога | DentalBook</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        /* Стили навигационного меню */
        #sidebar {
            width: 250px;
            background-color: #ffffff; /* Белый фон */
            padding: 20px;
            height: 100vh; /* Высота на весь экран */
            position: fixed;
            top: 0;
            left: 0;
            overflow-y: auto;
            border-right: 1px solid #ddd; /* Лёгкий бордюр */
            box-shadow: 2px 0 8px rgba(0, 0, 0, 0.05);
        }

        #sidebar h4 {
            font-weight: bold;
            color: #007bff; /* Синий текст заголовка */
            text-align: center;
            margin-bottom: 1.5rem;
        }

        #sidebar a {
            font-size: 1rem;
            color: #495057; /* Тёмно-серый текст */
            display: flex;
            align-items: center;
            text-decoration: none;
            margin-bottom: 15px;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }

        #sidebar a:hover {
            background-color: #e9ecef; /* Лёгкий серый фон при наведении */
            color: #007bff; /* Синий текст при наведении */
        }

        #sidebar a i {
            font-size: 1.2rem; /* Размер иконок */
            margin-right: 10px;
        }

        /* Контент страницы */
        #content {
            margin-left: 270px; /* Сдвигаем основной контент вправо */
            padding: 20px;
            background-color: #f8f9fa; /* Светлый фон контента */
            min-height: 100vh; /* Полная высота экрана */
        }

        /* Карточка профиля */
        .profile-card {
            background-color: #ffffff; /* Белый фон */
            border: 1px solid #ddd; /* Бордюр */
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Лёгкая тень */
            padding: 20px;
        }

        /* Иконка профиля */
        .profile-icon {
            width: 150px;
            height: 150px;
            background-color: #e9ecef; /* Светло-серый фон */
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

        .photo-buttons {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <!-- Навигационное меню слева -->
    <nav id="sidebar">
        <h4>DentalBook</h4>
        <ul class="list-unstyled">
        <!-- Секция "Мой профиль" -->
        <li>
            <a href="profiledantist.php" class="d-flex align-items-center text-decoration-none">
                <div class="d-flex justify-content-center align-items-center rounded-circle bg-light me-3" style="width: 40px; height: 40px;">
                    <i class="fas fa-user" style="font-size: 1.5rem;"></i>
                </div>
                <div>
                    <span class="fw-bold">Иван Иванов</span><br>
                    <small class="text-muted">Стоматолог</small>
                </div>
            </a>
        </li>

        <!-- Остальные ссылки меню -->
        <li><a href="/createcardpatient.php"><i class="fas fa-user-plus"></i>Создать карту</a></li>
        <li><a href="/cardpatient/cardpatient.php"><i class="fas fa-search"></i>Медицинские карты</a></li>
        <li><a href="/inspection.php"><i class="fas fa-file-alt"></i>Лист осмотра</a></li>
        <li><a href="#" onclick="logout()"><i class="fas fa-sign-out-alt me-2"></i> Выйти</a></li>
    </ul>
</nav>

    <!-- Основной контент -->
    <div id="content">
        <div class="container mt-5">
            <h2 class="mb-4">Профиль стоматолога | DentalBook</h2>
            
            <!-- Карточка профиля -->
            <div class="profile-card">
                <!-- Контент с сеткой -->
                <div class="row align-items-center">
                    <!-- Левая колонка: информация о стоматологе -->
                    <div class="col-md-8">
                        <div class="row mb-3">
                            <div class="col-1 text-center">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="col-11">
                                <strong>ФИО:</strong> Иван Иванов Иванович
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-1 text-center">
                                <i class="fas fa-tooth"></i>
                            </div>
                            <div class="col-11">
                                <strong>Специализация:</strong> Ортопедическая стоматология
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-1 text-center">
                                <i class="fas fa-briefcase"></i>
                            </div>
                            <div class="col-11">
                                <strong>Опыт работы:</strong> 10 лет
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-1 text-center">
                                <i class="fas fa-graduation-cap"></i>
                            </div>
                            <div class="col-11">
                                <strong>Квалификация:</strong> Кандидат медицинских наук
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
                                <i class="fas fa-sign-in-alt"></i>
                            </div>
                            <div class="col-11">
                                <strong>Последний вход:</strong> 18 декабря 2024, 14:30
                            </div>
                        </div>

                        <!-- Кнопка редактирования -->
                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                            <span class="fas fa-edit"></span> Редактировать
                        </button>
                    </div>

                    <!-- Правая колонка: иконка профиля -->
                    <div class="col-md-4 text-center">
                        <div class="profile-icon" id="profileImageContainer">
                            <i class="fas fa-user fa-5x"></i>
                        </div>
                        <div class="photo-buttons">     
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Модальное окно редактирования профиля -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProfileModalLabel">Редактирование профиля</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label class="form-label"><strong>ФИО:</strong></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                                <input type="text" class="form-control" value="Иван Иванов Иванович">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><strong>Специализация:</strong></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-tooth"></i></span>
                                <input type="text" class="form-control" value="Ортопедическая стоматология">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><strong>Опыт работы:</strong></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-briefcase"></i></span>
                                <input type="text" class="form-control" value="10 лет">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><strong>Квалификация:</strong></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-graduation-cap"></i></span>
                                <input type="text" class="form-control" value="Кандидат медицинских наук">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><strong>Контактный телефон:</strong></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                <input type="text" class="form-control" value="+7 (900) 123-45-67">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><strong>Фотография профиля:</strong></label>
                            <div class="photo-buttons">
                                <button class="btn btn-link" data-bs-toggle="modal" data-bs-target="#editPhotoModal">
                                    <i class="fas fa-camera"></i> Изменить фото
                                </button>
                                <button class="btn btn-link text-danger" id="deletePhotoButton" style="display: none;" onclick="removeProfilePhoto()">
                                    <i class="fas fa-trash"></i> Удалить фото
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                    <button type="button" class="btn btn-primary">Сохранить изменения</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Модальное окно редактирования фото профиля -->
    <div class="modal fade" id="editPhotoModal" tabindex="-1" aria-labelledby="editPhotoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPhotoModalLabel">Изменить фото профиля</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="photoForm">
                        <div class="mb-3">
                            <label for="profilePhoto" class="form-label">Выберите новое фото:</label>
                            <input type="file" class="form-control" id="profilePhoto" accept="image/*">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                    <button type="button" class="btn btn-primary" onclick="updateProfilePhoto()">Сохранить</button>
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

        // Обновление фото профиля
        function updateProfilePhoto() {
            const input = document.getElementById('profilePhoto');
            const file = input.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const container = document.getElementById('profileImageContainer');
                    container.innerHTML = `<img src="${e.target.result}" alt="Фото профиля">`;
                    document.getElementById('deletePhotoButton').style.display = 'inline-block'; // Показываем кнопку
                    document.getElementById('deletePhotoButtonModal').style.display = 'inline-block'; // Показываем кнопку в модальном окне
                };
                reader.readAsDataURL(file);
                document.getElementById('photoForm').reset();
                const modal = bootstrap.Modal.getInstance(document.getElementById('editPhotoModal'));
                modal.hide();
            } else {
                alert('Пожалуйста, выберите изображение.');
            }
        }

        // Удаление фото профиля
        function removeProfilePhoto() {
            const container = document.getElementById('profileImageContainer');
            container.innerHTML = '<i class="fas fa-user fa-5x text-secondary"></i>';
            document.getElementById('deletePhotoButton').style.display = 'none'; // Скрываем кнопку
            document.getElementById('deletePhotoButtonModal').style.display = 'none'; // Скрываем кнопку в модальном окне
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
</body>
</html>