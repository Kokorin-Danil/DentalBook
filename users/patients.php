<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Пациенты | DentalBook</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        #sidebar {
            width: 250px;
            background-color: #ffffff;
            padding: 20px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            overflow-y: auto;
            border-right: 1px solid #ddd;
            box-shadow: 2px 0 8px rgba(0, 0, 0, 0.05);
        }

        #content {
            margin-left: 270px;
            padding: 20px;
            background-color: #f8f9fa;
            min-height: 100vh;
        }

        .table-actions button {
            margin-right: 5px;
        }

        .search-bar {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .search-bar input {
            flex: 1;
            margin-right: 10px;
        }

        .search-bar .fa-search {
            position: relative;
            left: -30px;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div id="content">
        <div class="container mt-5">
            <h2 class="mb-4">Пациенты</h2>

            <div class="search-bar">
                <input type="text" id="searchInput" class="form-control" placeholder="Поиск по ФИО">
                <i class="fas fa-search"></i>
                <button class="btn btn-secondary ms-2"><i class="fas fa-filter"></i> Фильтр</button>
                <a href="/users/createcardpatient.php" class="btn btn-success ms-2"><i class="fas fa-plus"></i> Добавить пациента</a>
            </div>

            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Номер карты</th>
                        <th>ФИО</th>
                        <th>Телефон</th>
                        <th>Последний визит</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody id="patientTableBody">
                    <!-- Данные будут загружены динамически -->
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Функция для получения токена из cookies
        function getCookie(name) {
            const value = `; ${document.cookie}`;
            const parts = value.split(`; ${name}=`);
            if (parts.length === 2) return parts.pop().split(';').shift();
        }

        // Загружаем данные пациентов
        async function loadPatients() {
            const token = getCookie('token'); // Получаем токен из cookies

            if (!token) {
                alert('Токен не найден. Выполните вход заново.');
                window.location.href = '/auth.php';
                return;
            }

            try {
                const response = await fetch('http://localhost:3003/api/patient-cards/get/all', {
                    method: 'GET',
                    headers: {
                        Authorization: `Bearer ${token}`
                    }
                });

                if (!response.ok) {
                    throw new Error('Ошибка загрузки данных пациентов');
                }

                const patients = await response.json();
                populatePatientTable(patients);
            } catch (error) {
                console.error('Ошибка:', error);
                alert('Не удалось загрузить данные пациентов.');
            }
        }

        // Заполняем таблицу данными пациентов
        function populatePatientTable(patients) {
            const tableBody = document.getElementById('patientTableBody');
            tableBody.innerHTML = ''; // Очищаем таблицу

            patients.forEach((patient) => {
                const row = document.createElement('tr');

                row.innerHTML = `
                    <td>${patient.id}</td>
                    <td>${patient.fullName}</td>
                    <td>${patient.phoneNumber}</td>
                    <td>${patient.lastVisit}</td>
                    <td class="table-actions">
                        <a href="/users/view.php?id=${patient.id}" class="btn btn-sm btn-info view-patient" data-id="${patient.id}">
                            <i class="fas fa-eye"></i> Просмотреть
                        </a>
                        <button class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> Редактировать</button>
                        <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i> Удалить</button>
                    </td>
                `;

                tableBody.appendChild(row);
            });

            // Добавляем обработчик клика для кнопок "Просмотреть"
            document.querySelectorAll('.view-patient').forEach(button => {
                button.addEventListener('click', (event) => {
                    event.preventDefault();
                    const patientId = button.getAttribute('data-id');
                    window.location.href = `/users/view.php?patientCardId=${patientId}`;
                });
            });
        }

        // Загружаем данные пациентов при загрузке страницы
        document.addEventListener('DOMContentLoaded', loadPatients);
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
