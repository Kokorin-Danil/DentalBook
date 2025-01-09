<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Расписание</title>
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

        .table th {
            background-color: #007bff;
            color: white;
            text-align: center;
        }

        .table td {
            text-align: center;
            padding: 10px;
            border: 1px solid #ddd;
        }

        .appointment.free {
            background-color: #d1e7dd;
            color: #155724;
        }

        .appointment.occupied {
            background-color: #f8d7da;
            color: #721c24;
        }

        .current-date {
            margin-bottom: 20px;
            font-size: 1.2rem;
            font-weight: bold;
        }

        .month-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 10px;
        }

        .month-cell {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 10px;
            min-height: 100px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            transition: transform 0.2s;
        }

        .month-cell:hover {
            transform: scale(1.05);
        }

        .month-cell-header {
            font-weight: bold;
            color: #007bff;
            margin-bottom: 10px;
        }

        .month-cell-visit {
            font-size: 0.9rem;
            font-weight: bold;
        }

        .month-cell-visit.has-visit {
            color: #28a745;
        }

        .month-cell-visit.no-visit {
            color: #dc3545;
        }
    </style>
</head>
<body>
    <?php include '../users/navbar.php'; ?>

    <div class="container mt-5">
        <div class="header">
            <h2>Расписание</h2>
            <button class="btn btn-primary">Новый визит</button>
        </div>

        <div class="schedule-container">
            <div class="schedule-header mb-3">
                <label for="viewSelector" class="form-label">Вид расписания:</label>
                <select class="form-select d-inline" id="viewSelector" style="max-width: 200px; margin-right: 10px;">
                    <option value="day">На день</option>
                    <option value="week">На неделю</option>
                    <option value="month">На месяц</option>
                </select>
                <label for="scheduleDate" class="form-label">Выберите дату:</label>
                <input type="date" id="scheduleDate" class="form-control d-inline" style="max-width: 200px; margin-right: 10px;">
                <label for="doctorFilter" class="form-label">Выберите врача:</label>
                <select class="form-select d-inline" id="doctorFilter" style="max-width: 200px;">
                    <option value="all">Все врачи</option>
                </select>
            </div>

            <div id="dayView">
                <table class="table">
                    <thead>
                        <tr id="tableHeader">
                            <th>Время</th>
                        </tr>
                    </thead>
                    <tbody id="scheduleTableBody"></tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        const scheduleTableBody = document.getElementById('scheduleTableBody');
        const tableHeader = document.getElementById('tableHeader');
        const scheduleDateInput = document.getElementById('scheduleDate');
        const doctorFilter = document.getElementById('doctorFilter');
        const viewSelector = document.getElementById('viewSelector');
        const today = new Date().toISOString().split('T')[0];

        let scheduleData = {};

        // Установка текущей даты
        scheduleDateInput.value = today;

        // Загрузка расписания на день
        document.addEventListener('DOMContentLoaded', async () => {
            await loadSchedule(today);
        });

        // Обновление расписания при смене даты
        scheduleDateInput.addEventListener('change', async () => {
            await loadSchedule(scheduleDateInput.value);
        });

        // Фильтр врачей
        doctorFilter.addEventListener('change', () => {
            renderDaySchedule(scheduleData);
        });

        // Переключение видов расписания
        viewSelector.addEventListener('change', () => {
            const selectedView = viewSelector.value;
            if (selectedView === 'week') {
                window.location.href = '/kalendar/week.php';
            } else if (selectedView === 'month') {
                window.location.href = '/kalendar/month.php';
            }
        });

        async function loadSchedule(date) {
            try {
                const response = await fetch(`http://localhost:3003/api/patient-cards/schedule/${date}`);
                scheduleData = await response.json();
                populateDoctorFilter(scheduleData);
                renderDaySchedule(scheduleData);
            } catch (error) {
                console.error('Ошибка при загрузке расписания:', error);
                alert('Не удалось загрузить расписание');
            }
        }

        function populateDoctorFilter(data) {
            doctorFilter.innerHTML = '<option value="all">Все врачи</option>';
            Object.keys(data).forEach(doctor => {
                const option = document.createElement('option');
                option.value = doctor;
                option.textContent = doctor.replace(/\d+-/, '');
                doctorFilter.appendChild(option);
            });
        }

        function renderDaySchedule(data) {
            const filter = doctorFilter.value;
            const filteredData = filter === 'all' ? data : { [filter]: data[filter] };

            scheduleTableBody.innerHTML = '';
            tableHeader.innerHTML = '<th>Время</th>';

            const doctors = Object.keys(filteredData);
            doctors.forEach(doctor => {
                const th = document.createElement('th');
                th.textContent = doctor.replace(/\d+-/, '');
                tableHeader.appendChild(th);
            });

            const timeSlots = doctors.length > 0 ? filteredData[doctors[0]].map(item => item.time) : [];
            timeSlots.forEach(time => {
                const row = document.createElement('tr');
                const timeCell = document.createElement('td');
                timeCell.textContent = time;
                row.appendChild(timeCell);

                doctors.forEach(doctor => {
                    const appointment = filteredData[doctor]?.find(item => item.time === time);
                    const cell = document.createElement('td');
                    cell.textContent = appointment ? (appointment.status === 'available' ? 'Свободно' : 'Занято') : 'Свободно';
                    cell.className = `appointment ${appointment?.status === 'available' ? 'free' : 'occupied'}`;
                    row.appendChild(cell);
                });

                scheduleTableBody.appendChild(row);
            });
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
