<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Персонал - Доктора</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/jwt-decode/build/jwt-decode.min.js"></script>
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
            margin-bottom: 10px;
        }
        .action-buttons .btn {
            margin-right: 5px;
        }
        h1.h4 {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <?php include '../personal/personal.php'; ?>
    <div class="container mt-4">
        <div class="header-section">
            <h1 class="h4">Список докторов</h1>
        </div>

        <div class="table-container">
            <table class="table">
                <thead class="table-light">
                    <tr>
                        <th>Id</th>
                        <th>ФИО</th>
                        <th>Email</th>
                        <th>Телефон</th>
                        <th>Специальности</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody id="doctorTableBody">
                    <!-- Данные докторов загружаются динамически -->
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", async () => {
            const token = getCookie("token");

            if (!token) {
                alert("Ошибка доступа: Войдите в систему!");
                window.location.href = "login.html";
                return;
            }

            let userRole;
            try {
                const decoded = jwt_decode(token);
                userRole = decoded.role;

                if (userRole !== "manager") {
                    alert("У вас нет доступа к этой странице!");
                    window.location.href = "login.html";
                    return;
                }
            } catch (error) {
                console.error("Ошибка декодирования токена:", error);
                window.location.href = "login.html";
                return;
            }

            await loadDoctors();
        });

        async function loadDoctors() {
            try {
                const response = await fetch("http://localhost:3003/api/doctors/get/all");
                if (!response.ok) throw new Error("Ошибка загрузки данных");

                const data = await response.json();
                const tableBody = document.getElementById("doctorTableBody");
                tableBody.innerHTML = data
                    .map(doctor => `
                        <tr>
                            <td>${doctor.id}</td>
                            <td>${doctor.fullName}</td>
                            <td>${doctor.email}</td>
                            <td>${doctor.mobilePhone}</td>
                            <td>${doctor.specialty}</td>
                            <td class="action-buttons">
                                <a href="/personal/profiledoctorbyid.php?doctorId=${doctor.id}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i> Просмотр
                                </a>
                            </td>
                        </tr>
                    `)
                    .join("");
            } catch (error) {
                console.error("Ошибка:", error);
            }
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
