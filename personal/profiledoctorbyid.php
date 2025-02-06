<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Профиль доктора | DentalBook</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
        }

        #content {
            margin-left: 270px;
            padding: 20px;
            background-color: #f4f6f9;
            min-height: 100vh;
        }

        .header h2 {
            margin: 0;
            font-size: 1.8rem;
            color: #343a40;
            border-bottom: 2px solid #ddd;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .profile-card {
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .profile-icon img {
            height: 150px;
            width: 150px;
            border-radius: 50%;
            border: 1px solid #ddd;
            object-fit: cover;
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
            margin-top: 20px;
        }

        .table-container table {
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
        }
    </style>
</head>
<body>
    <?php include '../adminpanel/navbar.php'; ?>

    <div id="content" class="container mt-5">
        <h2 class="mb-4">Профиль доктора | DentalBook</h2>

        <!-- Doctor Profile Section -->
        <div class="profile-card mb-4">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="row mb-3">
                        <div class="col-1 text-center">
                            <i class="fas fa-user-md"></i>
                        </div>
                        <div class="col-11">
                            <strong>ФИО:</strong> <span id="doctorFullName">Загрузка...</span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-1 text-center">
                            <i class="fas fa-calendar"></i>
                        </div>
                        <div class="col-11">
                            <strong>Дата рождения:</strong> <span id="doctorBirthDate">Загрузка...</span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-1 text-center">
                            <i class="fas fa-user-md"></i>
                        </div>
                        <div class="col-11">
                            <strong>Специальность:</strong> <span id="doctorSpecialty">Загрузка...</span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-1 text-center">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="col-11">
                            <strong>Контактный телефон:</strong> <span id="doctorPhone">Загрузка...</span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-1 text-center">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="col-11">
                            <strong>Email:</strong> <span id="doctorEmail">Загрузка...</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <div class="profile-icon">
                        <img id="doctorAvatar" src="placeholder.jpg" alt="Аватар доктора">
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs Section -->
        <div class="tabs">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" href="#schedule" data-bs-toggle="tab"><i class="fas fa-calendar-alt"></i> Расписание</a>
                </li>
            </ul>
            <div class="tab-content mt-3">
                <!-- Schedule Tab -->
                <div class="tab-pane fade show active" id="schedule">
                    <h4 class="mb-4">Ваши записи на сегодня:</h4>
                    <div class="table-container">
                        <table class="table table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th>Время</th>
                                    <th>Пациент</th>
                                    <th>Тип визита</th>
                                    <th>Статус</th>
                                    <th>Действия</th>
                                </tr>
                            </thead>
                            <tbody id="scheduleTableBody">
                                <!-- Данные расписания будут загружены динамически -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', async () => {
            const urlParams = new URLSearchParams(window.location.search);
            const doctorId = urlParams.get('doctorId');

            if (!doctorId) {
                alert('Доктор ID не указан');
                return;
            }

            try {
                // Загрузка профиля доктора
                const profileResponse = await fetch(`http://localhost:3003/api/doctors/profile/${doctorId}`);
                const profileData = await profileResponse.json();
                document.getElementById('doctorFullName').textContent = profileData.fullName;
                document.getElementById('doctorBirthDate').textContent = profileData.dateOfBirth;
                document.getElementById('doctorSpecialty').textContent = profileData.specialty;
                document.getElementById('doctorPhone').textContent = profileData.mobilePhone;
                document.getElementById('doctorEmail').textContent = profileData.email;
                document.getElementById('doctorAvatar').src = profileData.avatar;

                // Загрузка расписания
                const scheduleResponse = await fetch(`http://localhost:3003/api/doctors/shudle/${doctorId}`);
                const scheduleData = await scheduleResponse.json();

                // Сортировка расписания по времени
                const sortedSchedule = scheduleData.sort((a, b) => new Date(`1970-01-01T${a.visitTime}`) - new Date(`1970-01-01T${b.visitTime}`));

                const scheduleTableBody = document.getElementById('scheduleTableBody');
                scheduleTableBody.innerHTML = sortedSchedule.map(visit => `
                    <tr>
                        <td>${visit.visitTime}</td>
                        <td>${visit.patient.fullName}</td>
                        <td>${visit.visitType}</td>
                        <td>${visit.visitStatus}</td>
                        <td>
                            <a href="/users/view.php?patientCardId=${visit.patient.id}" class="btn btn-sm btn-info" title="Просмотреть">
                                <i class="fas fa-eye"></i> Просмотреть
                            </a>
                        </td>
                    </tr>
                `).join('');
            } catch (error) {
                console.error(error);
                alert('Ошибка загрузки данных');
            }
        });
    </script>
</body>
</html>
