<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DentalBook | Навигация</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/jwt-decode/build/jwt-decode.min.js"></script>
    <style>
        /* Стили навигационного меню */
        #sidebar {
            width: 250px;
            background-color: #f8f9fa;
            padding: 20px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            overflow-y: auto;
            border-right: 1px solid #ddd;
            box-shadow: 2px 0 8px rgba(0, 0, 0, 0.05);
        }

        #sidebar h4 {
            font-weight: bold;
            color: #007bff;
            text-align: center;
            margin-bottom: 1.5rem;
        }

        #sidebar a {
            font-size: 1rem;
            color: #495057;
            display: flex;
            align-items: center;
            text-decoration: none;
            margin-bottom: 15px;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }

        #sidebar a:hover {
            background-color: #e9ecef;
            color: #007bff;
        }

        #sidebar a i {
            font-size: 1.2rem;
            margin-right: 10px;
        }
    </style>
</head>
<body>

    <!-- Навигационное меню слева -->
    <nav id="sidebar">
        <h4>DentalBook</h4>
        <ul class="list-unstyled" id="navLinks">
            <!-- Навигационные ссылки будут добавлены через JS -->
        </ul>
    </nav>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const token = getCookie("token");

            if (!token) {
                alert("Ошибка доступа: Войдите в систему!");
                window.location.href = "/login.html";
                return;
            }

            let userRole;
            try {
                const decoded = jwt_decode(token);
                userRole = decoded.role;
            } catch (error) {
                console.error("Ошибка декодирования токена:", error);
                window.location.href = "/login.html";
                return;
            }

            const navLinks = document.getElementById("navLinks");
            let menuHTML = `
                <li><a href="/index.php"><i class="fas fa-home"></i> Главная</a></li>
            `;

            if (userRole === "admin") {
                menuHTML += `
                    <li><a href="/adminpanel/doctors.php"><i class="fas fa-users"></i> Персонал</a></li>
                    <li><a href="/adminpanel/patients.php"><i class="fas fa-users"></i> Пациенты</a></li>
                    <li><a href="/users/patients.php"><i class="fas fa-folder-open"></i> Карты пациентов</a></li>
                `;
            } else if (userRole === "doctor") {
                menuHTML += `
                    <li><a href="/personal/profiledoctor.php"><i class="fas fa-user"></i> Мой профиль</a></li>
                    <li><a href="/users/createcardpatient.php"><i class="fas fa-address-card"></i> Создать карту</a></li>
                    <li><a href="/inspection/initial.php"><i class="fas fa-clipboard-check"></i> Лист осмотра</a></li>
                    <li><a href="/users/createanketa.php"><i class="fas fa-clipboard"></i> Заполнить анкету</a></li>
                    <li><a href="/users/patients.php"><i class="fas fa-folder-open"></i> Карты пациентов</a></li>
                    <li><a href="/kalendar/kalendar.php"><i class="fas fa-calendar-alt"></i> Записи</a></li>
                `;
            } else if (userRole === "manager") {
                menuHTML += `
                    <li><a href="/kalendar/kalendar.php"><i class="fas fa-calendar-alt"></i> Записи</a></li>
                    <li><a href="/users/createcardpatient.php"><i class="fas fa-address-card"></i> Создать карту</a></li>
                    <li><a href="/personal/doctors.php"><i class="fas fa-users"></i> Персонал</a></li>
                `;
            } else if (userRole === "client") {
                menuHTML += `
                    <li><a href="/profile/profilepatient.php"><i class="fas fa-user"></i> Мой профиль</a></li>
                    <li><a href="/kalendar/kalendar.php"><i class="fas fa-calendar-alt"></i> Мои записи</a></li>
                `;
            } else {
                alert("Неизвестная роль! Выход...");
                logout();
                return;
            }

            menuHTML += `
                <li><a href="/logout.php" onclick="logout()"><i class="fas fa-sign-out-alt"></i> Выйти</a></li>
            `;

            navLinks.innerHTML = menuHTML;
        });

        function logout() {
            document.cookie = "token=; path=/; expires=Thu, 01 Jan 1970 00:00:00 UTC;";
            window.location.href = "/login.html";
        }

        function getCookie(name) {
            const value = `; ${document.cookie}`;
            const parts = value.split(`; ${name}=`);
            return parts.length === 2 ? parts.pop().split(";").shift() : "";
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
