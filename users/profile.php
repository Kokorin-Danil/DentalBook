<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Профиль пациента | DentalBook</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
        }

        .profile-card {
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .profile-icon {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100px;
            width: 100px;
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 50%;
            margin: auto;
        }

        .actions {
            display: flex;
            gap: 10px;
            margin-bottom: 15px;
        }

        .tabs {
            margin-top: 20px;
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
    </style>
</head>
<body>

    <div id="content" class="container mt-5">
        <h2 class="mb-4">Профиль пациента | DentalBook</h2>

        <!-- Карточка профиля -->
        <div id="patientProfile" class="profile-card">
            <div class="text-center">Загрузка данных...</div>
        </div>

        <!-- Действия -->
        <div class="actions">
            <button class="btn btn-primary"><i class="fas fa-file-alt"></i> Анкета</button>
            <button class="btn btn-secondary"><i class="fas fa-file-contract"></i> Договор</button>
            <button class="btn btn-info"><i class="fas fa-star"></i> Оценка</button>
            <button class="btn btn-danger"><i class="fas fa-print"></i> Печать</button>
        </div>
        
        <!-- Tabs -->
        <div class="tabs">
            <ul class="nav nav-tabs" id="tabs">
                <li class="nav-item">
                    <a id="visitsTab" class="nav-link" href="/users/view.php"><i class="fas fa-calendar-check"></i> Визиты</a>
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
                    <a class="nav-link" id="notesLink"><i class="fas fa-sticky-note"></i> Примечания</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#documents" data-bs-toggle="tab"><i class="fas fa-folder"></i> Документы</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#personal-data" data-bs-toggle="tab"><i class="fas fa-id-card"></i> Персональные данные</a>
                </li>
            </ul>
        </div>
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
            } catch (error) {
                console.error('Ошибка:', error);
                alert('Не удалось загрузить данные пациента.');
            }
        }

        // Заполняем карточку профиля данными пациента
        function populateProfile(profile) {
            const profileContainer = document.getElementById('patientProfile');
            profileContainer.innerHTML = `
                <div class="row">
                    <div class="col-md-8">
                        <p><strong>ФИО:</strong> ${profile.fullName}</p>
                        <p><strong>Дата рождения:</strong> ${profile.dateOfBirth}</p>
                        <p><strong>Полис:</strong> ${profile.policy}</p>
                        <p><strong>Телефон:</strong> ${profile.phoneNumber}</p>
                        <p><strong>Адрес:</strong> ${profile.address}</p>
                        <p><strong>Email:</strong> ${profile.email}</p>
                        <p><strong>Последний вход:</strong> ${profile.lastLogin || 'Неизвестно'}</p>
                    </div>
                    <div class="col-md-4 text-center">
                        <div class="profile-icon">
                            <i class="fas fa-user fa-5x"></i>
                        </div>
                    </div>
                </div>
            `;
        }

        // Инициализация загрузки данных
        document.addEventListener('DOMContentLoaded', loadPatientProfile);
    </script>
</body>
</html>
