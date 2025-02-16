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
    <div id="content" class="main-content">
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
                <div class="col-md-4 d-flex justify-content-center align-items-center">
                    <div class="rounded-circle overflow-hidden" style="width: 150px; height: 150px;">
                        <img id="avatar" src="" alt="Аватар" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>

        <!-- Действия -->
        <div class="mb-4">
            <button class="btn btn-primary" id="anketaButton"><i class="fas fa-file-alt"></i> Анкета</button>
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
                <a id="picturesLink" class="nav-link" href="#"><i class="fas fa-image"></i> Снимки</a>
            </li>
            <li class="nav-item">
                <a id="notesLink" class="nav-link" href="#"><i class="fas fa-sticky-note"></i> Примечания</a>
            </li>
            <li class="nav-item">
                <a id="personalDataTab" class="nav-link" href="#"><i class="fas fa-id-card"></i> Персональные данные</a>
            </li>
            <li class="nav-item">
                <a id="medicalRecordsTab" class="nav-link" href="#"><i class="fas fa-file-medical-alt"></i> История медицинских записей</a>
            </li>
        </ul>
    </div>

    <!-- Скрипты -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script type="module">
    import { getToken, parseJwt } from "/js/auth.js";

    async function checkPatientAccess(token, patientCardId) {
        try {
            const response = await fetch(`http://localhost:3003/api/users/check/${patientCardId}`, {
                headers: { Authorization: `Bearer ${token}` }
            });

            if (response.status === 403) {
                alert('У вас нет доступа к этой карте пациента.');
                if (document.referrer) {
                    window.location.href = document.referrer; // Возвращает на предыдущую страницу
                } else {
                    window.location.href = '/index.php'; // Перенаправляет на страницу авторизации
                }
                return false;
            }

            return true;
        } catch (error) {
            console.error('Ошибка проверки доступа:', error);
            alert('Ошибка при проверке доступа. Попробуйте снова.');
            return false;
        }
    }

    async function checkAccess() {
        const token = getToken();
        const patientCardId = new URLSearchParams(window.location.search).get('patientCardId');

        if (!token || !patientCardId) {
            alert("Ошибка доступа. Перенаправление на страницу входа.");
            window.location.href = "/index.php";
            return;
        }

        // Проверяем доступ перед загрузкой данных
        const hasAccess = await checkPatientAccess(token, patientCardId);
        if (!hasAccess) {
            document.body.innerHTML = "<h3 class='text-center text-danger'>У вас нет доступа к этой странице.</h3>";
            return;
        }

        await loadPatientProfile();
    }

    document.addEventListener('DOMContentLoaded', checkAccess);
</script>

<script>
    // Функция для получения токена из cookies
    function getCookie(name) {
        const value = `; ${document.cookie}`;
        const parts = value.split(`; ${name}=`);
        return parts.length === 2 ? parts.pop().split(';').shift() : null;
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
            window.location.href = '/index.php';
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

            // Устанавливаем ссылки для вкладок
            document.getElementById('visitsTab').href = `/users/view.php?patientCardId=${patientCardId}`;
            document.getElementById('formulaTab').href = `/users/formula.php?patientCardId=${patientCardId}`;
            document.getElementById('medicalRecordsTab').href = `/users/listosmotra.php?patientCardId=${patientCardId}`;
            document.getElementById('personalDataTab').href = `/users/personaldata.php?patientCardId=${patientCardId}`;
            document.getElementById('picturesLink').href = `/users/pictures.php?patientCardId=${patientCardId}`;
            document.getElementById('notesLink').href = `/users/notes.php?patientCardId=${patientCardId}`;
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
            <p><strong>Телефон:</strong> ${profile.phoneNumber}</p>
            <p><strong>Адрес:</strong> ${profile.address}</p>
            <p><strong>Email:</strong> ${profile.email}</p>
            <p><strong>Последний вход:</strong> ${profile.lastLogin}</p>
        `;

        const avatarElement = document.getElementById('avatar');
        avatarElement.src = profile.avatar || 'default_avatar.png';
    }

    // Инициализация загрузки данных
    document.addEventListener('DOMContentLoaded', () => {
        const patientCardId = getPatientCardId();
        const anketaButton = document.getElementById('anketaButton');

        if (anketaButton && patientCardId) {
            anketaButton.addEventListener('click', () => {
                window.location.href = `/users/anketa.php?patientCardId=${patientCardId}`;
            });
        }
    });
</script>

</body>
</html>
