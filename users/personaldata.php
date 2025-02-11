<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Персональные данные | DentalBook</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'profile.php'; ?>
    <?php include '../adminpanel/navbar.php'; ?>

    <div class="container mt-5">
        <!-- Таблица персональных данных -->
        <div class="table-container">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Номер полиса</th>
                        <th>СНИЛС</th>
                        <th>Паспорт</th>
                    </tr>
                </thead>
                <tbody id="personalDataTableBody">
                    <!-- Данные персональных документов будут загружены динамически -->
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script type="module">
    import { getToken, parseJwt } from "/js/auth.js";

    function checkAccess() {
        const token = getToken();

        if (!token) {
            alert('Вы не авторизованы!');
            window.location.replace('/index.php');
            return;
        }

        const decodedToken = parseJwt(token);
        const userRole = decodedToken?.role;

        if (!['admin', 'doctor', 'client'].includes(userRole)) {
            alert('У вас нет доступа к этой странице!');
            if (document.referrer) {
                window.location.href = document.referrer; // Возвращаем на предыдущую страницу
            } else {
                window.location.replace('/index.php'); // Если истории нет, направляем на index.php
            }
        }
    }

    checkAccess();
</script>
    <script>
        // Получение ID карты пациента из URL
        function getPatientCardId() {
            const params = new URLSearchParams(window.location.search);
            return params.get('patientCardId');
        }

        // Получение токена из cookies
        function getCookie(name) {
            const value = `; ${document.cookie}`;
            const parts = value.split(`; ${name}=`);
            if (parts.length === 2) return parts.pop().split(';').shift();
        }

        // Загрузка персональных данных
        async function loadPersonalData() {
            const patientCardId = getPatientCardId();
            const token = getCookie('token');

            if (!patientCardId || !token) {
                alert('ID пациента или токен отсутствуют.');
                return;
            }

            try {
                const response = await fetch(`http://localhost:3003/api/patient-cards/document/get/${patientCardId}`, {
                    headers: { Authorization: `Bearer ${token}` },
                });

                if (!response.ok) {
                    throw new Error('Ошибка загрузки персональных данных');
                }

                const data = await response.json();
                const personalDataTableBody = document.getElementById('personalDataTableBody');
                personalDataTableBody.innerHTML = `
                    <tr>
                        <td>${data.policyNumber || 'Нет данных'}</td>
                        <td>${data.snils || 'Нет данных'}</td>
                        <td>${data.passport || 'Нет данных'}</td>
                    </tr>
                `;
            } catch (error) {
                console.error('Ошибка загрузки персональных данных:', error);
                alert('Не удалось загрузить персональные данные.');
            }
        }

        // Инициализация страницы
        document.addEventListener('DOMContentLoaded', loadPersonalData);
    </script>
</body>
</html>
