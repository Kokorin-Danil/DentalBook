<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Профиль пациента | DentalBook</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        #content {
            margin-top: 50px;
        }
        .card {
            margin-bottom: 20px;
        }
        .rounded-circle {
            overflow: hidden;
            width: 150px;
            height: 150px;
        }
    </style>
</head>
<body>
<?php include '../adminpanel/navbar.php'; ?>
    <div id="content" class="container mt-5">
        <h2 class="mb-4">Профиль пациента | DentalBook</h2>

        <!-- Карточка профиля -->
        <div id="patientProfile" class="card shadow-sm mb-4">
            <div class="row g-0">
                <div class="col-md-8">
                    <div class="card-body">
                        <p><strong>ФИО:</strong> Загрузка...</p>
                        <p><strong>Дата рождения:</strong> Загрузка...</p>
                        <p><strong>Телефон:</strong> Загрузка...</p>
                        <p><strong>Адрес:</strong> Загрузка...</p>
                        <p><strong>Email:</strong> Загрузка...</p>
                        <p><strong>Последний вход:</strong> Загрузка...</p>
                    </div>
                </div>
                <div class="col-md-4 d-flex flex-column justify-content-center align-items-center">
                    <div class="rounded-circle">
                        <img id="avatar" src="" alt="Аватар" class="img-fluid">
                    </div>
                    <button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#avatarModal">Обновить аватар</button>
                </div>
            </div>
        </div>

        <!-- Действия -->
        <div class="mb-4">
            <button class="btn btn-primary"><i class="fas fa-file-alt"></i> Анкета</button>
        </div>

        <!-- Tabs -->
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a id="visitsTab" class="nav-link"><i class="fas fa-calendar-check"></i> Визиты</a>
            </li>
            <li class="nav-item">
                <a id="formulaTab" class="nav-link"><i class="fas fa-tooth"></i> Формула</a>
            </li>
            <li class="nav-item">
                <a id="picturesLink" class="nav-link"><i class="fas fa-image"></i> Снимки</a>
            </li>
            <li class="nav-item">
                <a id="notesLink" class="nav-link"><i class="fas fa-sticky-note"></i> Примечания</a>
            </li>
            <li class="nav-item">
                <a id="personalDataTab" class="nav-link"><i class="fas fa-id-card"></i> Персональные данные</a>
            </li>
            <li class="nav-item">
                <a id="medicalRecordsTab" class="nav-link"><i class="fas fa-file-medical-alt"></i> История медицинских записей</a>
            </li>
        </ul>
    </div>

    <!-- Модальное окно для обновления аватара -->
    <div class="modal fade" id="avatarModal" tabindex="-1" aria-labelledby="avatarModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="avatarModalLabel">Обновить аватар</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                </div>
                <div class="modal-body">
                    <form id="avatarForm">
                        <div class="mb-3">
                            <label for="avatarInput" class="form-label">Выберите изображение</label>
                            <input type="file" class="form-control" id="avatarInput" accept="image/*" required>
                        </div>
                        <button type="button" class="btn btn-primary" onclick="uploadAvatar()">Загрузить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Скрипты -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function getCookie(name) {
        const value = `; ${document.cookie}`;
        const parts = value.split(`; ${name}=`);
        if (parts.length === 2) return parts.pop().split(';').shift();
    }

    async function fetchPatientCardId() {
        const token = getCookie('token');
        if (!token) {
            alert('Вы не авторизованы. Пожалуйста, выполните вход.');
            window.location.href = '/index.php';
            return;
        }

        try {
            const response = await fetch('http://localhost:3003/api/users/getId/patientCard', {
                headers: { Authorization: `Bearer ${token}` }
            });

            if (!response.ok) throw new Error('Ошибка получения номера карты пациента');

            const data = await response.json();
            const patientCardId = data.patientCardId;

            // Обновляем ссылки с ID пациента
            document.getElementById('visitsTab').href = `/users/view.php?patientCardId=${patientCardId}`;
            document.getElementById('formulaTab').href = `/users/formula.php?patientCardId=${patientCardId}`;
            document.getElementById('picturesLink').href = `/users/pictures.php?patientCardId=${patientCardId}`;
            document.getElementById('notesLink').href = `/users/notes.php?patientCardId=${patientCardId}`;
            document.getElementById('personalDataTab').href = `/users/personaldata.php?patientCardId=${patientCardId}`;
            document.getElementById('medicalRecordsTab').href = `/users/medicalrecords.php?patientCardId=${patientCardId}`;
        } catch (error) {
            console.error('Ошибка получения номера карты пациента:', error);
            alert('Не удалось получить номер карты пациента.');
        }
    }

    async function loadUserProfile() {
        const token = getCookie('token');
        let userRole = null;

        try {
            const decoded = jwt_decode(token);
            userRole = decoded.role; // Получаем роль пользователя

            if (userRole === "client") {
                // Скрываем кнопку "Обновить аватар" для клиента
                const updateAvatarButton = document.querySelector('button[data-bs-target="#avatarModal"]');
                if (updateAvatarButton) {
                    updateAvatarButton.style.display = "none";
                }
            }

            const response = await fetch('http://localhost:3003/api/users/profile', {
                headers: { Authorization: `Bearer ${token}` }
            });

            if (!response.ok) throw new Error('Ошибка загрузки профиля');

            const data = await response.json();
            const profile = data.profile;

            document.querySelector('.card-body').innerHTML = `
                <p><strong>ФИО:</strong> ${profile.fullName}</p>
                <p><strong>Дата рождения:</strong> ${profile.dateOfBirth}</p>
                <p><strong>Телефон:</strong> ${profile.phoneNumber}</p>
                <p><strong>Адрес:</strong> ${profile.address}</p>
                <p><strong>Email:</strong> ${profile.email}</p>
                <p><strong>Последний вход:</strong> ${profile.lastLogin || 'Неизвестно'}</p>
            `;

            document.getElementById('avatar').src = profile.avatar || 'default_avatar.png';
        } catch (error) {
            console.error('Ошибка загрузки профиля:', error);
            alert('Не удалось загрузить данные профиля.');
        }
    }

    document.addEventListener('DOMContentLoaded', async () => {
        await fetchPatientCardId();
        await loadUserProfile();
    });
</script>

</body>
</html>
