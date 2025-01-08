<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Расписание на неделю</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 20px 0;
        }

        .schedule-container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .schedule-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 10px;
        }

        .day-column {
            display: flex;
            flex-direction: column;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 10px;
            min-height: 300px;
        }

        .day-header {
            text-align: center;
            font-weight: bold;
            margin-bottom: 10px;
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            border-radius: 8px;
        }

        .appointment {
            margin: 5px 0;
            padding: 10px;
            border-radius: 4px;
        }

        .appointment.free {
            background-color: #d1e7dd;
            color: #155724;
        }

        .appointment.occupied {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <?php include '../users/navbar.php'; ?>

    <div class="container mt-5">
        <div class="header">
            <h2>Расписание на неделю</h2>
            <button class="btn btn-primary">Новый визит</button>
        </div>

        <div class="schedule-container">
            <div class="schedule-header mb-3">
                <label for="scheduleDate" class="form-label">Выберите дату:</label>
                <input type="date" id="scheduleDate" class="form-control d-inline" style="max-width: 200px; margin-right: 10px;">
                <label for="doctorFilter" class="form-label">Выберите врача:</label>
                <select class="form-select d-inline" id="doctorFilter" style="max-width: 200px;">
                    <option value="all">Все врачи</option>
                </select>
            </div>

            <div class="schedule-grid" id="weekScheduleBody"></div>
        </div>
    </div>

    <script>
        const scheduleDateInput = document.getElementById('scheduleDate');
        const doctorFilter = document.getElementById('doctorFilter');
        const weekScheduleBody = document.getElementById('weekScheduleBody');
        const today = new Date().toISOString().split('T')[0];

        let weekData = {};

        scheduleDateInput.value = today;

        document.addEventListener('DOMContentLoaded', async () => {
            await loadWeeklySchedule(scheduleDateInput.value);
        });

        scheduleDateInput.addEventListener('change', async () => {
            await loadWeeklySchedule(scheduleDateInput.value);
        });

        doctorFilter.addEventListener('change', () => {
            renderWeekSchedule(weekData);
        });

        async function loadWeeklySchedule(date) {
            try {
                const startDate = getMonday(new Date(date));
                const endDate = new Date(startDate);
                endDate.setDate(startDate.getDate() + 6);

                const response = await fetch(`http://localhost:3003/api/patient-cards/schedule/weekly/${startDate.toISOString().split('T')[0]}/${endDate.toISOString().split('T')[0]}`);
                weekData = await response.json();

                populateDoctorFilter(weekData);
                renderWeekSchedule(weekData);
            } catch (error) {
                console.error('Ошибка при загрузке расписания на неделю:', error);
                alert('Не удалось загрузить расписание');
            }
        }

        function getMonday(date) {
            const day = date.getDay();
            const diff = day === 0 ? -6 : 1 - day; // Если воскресенье, сделать -6, иначе 1-понедельник
            return new Date(date.setDate(date.getDate() + diff));
        }

        function populateDoctorFilter(data) {
            doctorFilter.innerHTML = '<option value="all">Все врачи</option>';
            const doctors = Object.keys(data);
            doctors.forEach(doctor => {
                const option = document.createElement('option');
                option.value = doctor;
                option.textContent = doctor.replace(/^\d+-/, ''); // Убирает номера в начале имени врача
                doctorFilter.appendChild(option);
            });
        }

        function renderWeekSchedule(data) {
            const filter = doctorFilter.value;
            weekScheduleBody.innerHTML = '';
            const daysOfWeek = ["Понедельник", "Вторник", "Среда", "Четверг", "Пятница", "Суббота", "Воскресенье"];
            const startDate = getMonday(new Date(scheduleDateInput.value));

            for (let i = 0; i < 7; i++) {
                const dayColumn = document.createElement('div');
                dayColumn.className = 'day-column';

                const date = new Date(startDate);
                date.setDate(startDate.getDate() + i);

                const dayHeader = document.createElement('div');
                dayHeader.className = 'day-header';
                dayHeader.textContent = `${date.getDate()} ${daysOfWeek[i]}`;
                dayColumn.appendChild(dayHeader);

                Object.keys(data).forEach(doctor => {
                    if (filter === 'all' || doctor === filter) {
                        const appointments = data[doctor]?.[date.toISOString().split('T')[0]] || [];
                        appointments.forEach(app => {
                            const appointmentDiv = document.createElement('div');
                            appointmentDiv.className = `appointment ${app.status.toLowerCase()}`;
                            appointmentDiv.textContent = `${app.time} - ${app.type} (${app.status})`;
                            dayColumn.appendChild(appointmentDiv);
                        });
                    }
                });

                weekScheduleBody.appendChild(dayColumn);
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
