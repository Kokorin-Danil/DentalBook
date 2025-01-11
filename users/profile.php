<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Профиль пациента | DentalBook</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div id="content" class="container mt-5">
        <h2 class="mb-4">Профиль пациента | DentalBook</h2>

        <!-- Карточка профиля -->
        <div id="patientProfile" class="card shadow-sm mb-4">
            <div class="row g-0">
                <div class="col-md-8">
                    <div class="card-body">
                        <p><strong>ФИО:</strong> Загрузка...</p>
                        <p><strong>Дата рождения:</strong> Загрузка...</p>
                        <p><strong>Полис:</strong> Загрузка...</p>
                        <p><strong>Телефон:</strong> Загрузка...</p>
                        <p><strong>Адрес:</strong> Загрузка...</p>
                        <p><strong>Email:</strong> Загрузка...</p>
                        <p><strong>Последний вход:</strong> Загрузка...</p>
                    </div>
                </div>
                <div class="col-md-4 d-flex justify-content-center align-items-center">
                    <div class="rounded-circle overflow-hidden" style="width: 150px; height: 150px;">
                        <img id="avatar" src="" alt="Аватар" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>

        <!-- Действия -->
        <div class="mb-4">
            <button class="btn btn-primary"><i class="fas fa-file-alt"></i> Анкета</button>
            <button class="btn btn-secondary"><i class="fas fa-file-contract"></i> Договор</button>
            <button class="btn btn-info"><i class="fas fa-star"></i> Оценка</button>
            <button class="btn btn-danger"><i class="fas fa-print"></i> Печать</button>
        </div>

        <!-- Tabs -->
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a id="visitsTab" class="nav-link" href="/users/view.php"><i class="fas fa-calendar-check"></i> Визиты</a>
            </li>
            <li class="nav-item">
                <a id="formulaTab" class="nav-link" href="/users/formula.php"><i class="fas fa-tooth"></i> Формула</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#payments" data-bs-toggle="tab"><i class="fas fa-dollar-sign"></i> Оплаты</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/users/treatmentplan.php"><i class="fas fa-notes-medical"></i> План лечения</a>
            </li>
            <li class="nav-item">
                <a id="picturesLink" class="nav-link" href="#"><i class="fas fa-image"></i> Снимки</a>
            </li>
            <li class="nav-item">
                <a id="notesLink" class="nav-link" href="#"><i class="fas fa-sticky-note"></i> Примечания</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#documents" data-bs-toggle="tab"><i class="fas fa-folder"></i> Документы</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#personal-data" data-bs-toggle="tab"><i class="fas fa-id-card"></i> Персональные данные</a>
            </li>
        </ul>
    </div>

    <!-- Скрипты -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Функция для получения токена из cookies
        function getCookie(name) {
            const value = `; ${document.cookie}`;
            const parts = value.split(`; ${name}=`);
            if (parts.length === 2) return parts.pop().split(';').shift();
        }

        // Функция для получения patientCardId из URL
        function getPatientCardId() {
            const params = new URLSearchParams(window.location.search);
            return params.get('patientCardId');
        }

        // Загрузка данных профиля пациента
        async function loadPatientProfile() {
            const token = getCookie('token');
            const patientCardId = getPatientCardId();

            if (!token) {
                alert('Токен не найден. Выполните вход заново.');
                window.location.href = '/auth.php';
                return;
            }

            if (!patientCardId) {
                alert('ID пациента не указан.');
                return;
            }

            try {
                const response = await fetch(`http://localhost:3003/api/patient-cards/get/patient_profile/${patientCardId}`, {
                    method: 'GET',
                    headers: {
                        Authorization: `Bearer ${token}`
                    }
                });

                if (!response.ok) {
                    throw new Error('Ошибка загрузки данных пациента');
                }

                const data = await response.json();
                populateProfile(data.profile);

                // Устанавливаем ссылку для вкладки "Визиты"
                const visitsTab = document.getElementById('visitsTab');
                visitsTab.href = `/users/view.php?patientCardId=${patientCardId}`;

                // Устанавливаем ссылку для вкладки "Формула"
                const formulaTab = document.getElementById('formulaTab');
                formulaTab.href = `/users/formula.php?patientCardId=${patientCardId}`;

                // Устанавливаем ссылки для других вкладок
                const picturesLink = document.getElementById('picturesLink');
                const notesLink = document.getElementById('notesLink');
                if (picturesLink && patientCardId) {
                    picturesLink.href = `/users/pictures.php?patientCardId=${patientCardId}`;
                }
                if (notesLink && patientCardId) {
                    notesLink.href = `/users/notes.php?patientCardId=${patientCardId}`;
                }
            } catch (error) {
                console.error('Ошибка:', error);
                alert('Не удалось загрузить данные пациента.');
            }
        }

        // Заполняем карточку профиля данными пациента
        function populateProfile(profile) {
            const profileContainer = document.querySelector('.card-body');
            profileContainer.innerHTML = `
                <p><strong>ФИО:</strong> ${profile.fullName}</p>
                <p><strong>Дата рождения:</strong> ${profile.dateOfBirth}</p>
                <p><strong>Полис:</strong> ${profile.policy}</p>
                <p><strong>Телефон:</strong> ${profile.phoneNumber}</p>
                <p><strong>Адрес:</strong> ${profile.address}</p>
                <p><strong>Email:</strong> ${profile.email}</p>
                <p><strong>Последний вход:</strong> ${profile.lastLogin || 'Неизвестно'}</p>
            `;

            const avatarElement = document.getElementById('avatar');
            avatarElement.src = profile.avatar || 'default_avatar.png';
        }

        // Инициализация загрузки данных
        document.addEventListener('DOMContentLoaded', loadPatientProfile);
    </script>
</body>
</html>
