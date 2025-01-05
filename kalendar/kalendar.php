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

        .schedule-header {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            gap: 20px;
            margin-bottom: 15px;
        }

        .schedule-header .form-select,
        .schedule-header .form-control {
            max-width: 150px;
        }

        .dropdown-header {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .table {
            border-collapse: collapse;
            width: 100%;
        }

        .table th {
            background-color: #007bff;
            color: white;
            text-align: center;
            padding: 10px;
        }

        .table td {
            text-align: center;
            padding: 10px;
            border: 1px solid #ddd;
        }

        .time-column {
            text-align: right;
            padding-right: 15px;
            font-weight: bold;
        }

        .appointment {
            border-radius: 5px;
            padding: 5px;
            margin: 5px 0;
            font-size: 0.9rem;
            text-align: center;
            border: 1px solid #ccc;
        }

        .appointment.booked {
            background-color: #d1e7dd;
        }

        .appointment.pending {
            background-color: #f8d7da;
        }

        .appointment.confirmed {
            background-color: #fff3cd;
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
            min-height: 500px;
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

        .month-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 10px;
            margin-top: 20px;
        }

        .month-cell {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            height: 150px;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .month-cell:hover {
            transform: scale(1.02);
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.15);
        }

        .month-cell-header {
            font-weight: bold;
            font-size: 1rem;
            color: #007bff;
            text-align: center;
            margin-bottom: 10px;
        }

        .has-visit {
            font-size: 0.9rem;
            font-weight: bold;
            color: #28a745;
            text-align: center;
        }

        .no-visit {
            font-size: 0.9rem;
            font-weight: bold;
            color: #dc3545;
            text-align: center;
        }

        .month-cell-footer {
            margin-top: auto;
            font-size: 0.8rem;
            text-align: center;
            color: #6c757d;
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
            <div class="schedule-header">
                <div class="dropdown-header">
                    <label for="viewSelector">Расписание:</label>
                    <select class="form-select" id="viewSelector">
                        <option value="day">На день</option>
                        <option value="week">На неделю</option>
                        <option value="month">На месяц</option>
                    </select>
                </div>
                <div class="dropdown-header">
                    <label for="doctorFilter">Фильтр:</label>
                    <select class="form-select" id="doctorFilter">
                        <option value="all">Все доктора</option>
                        <option value="aska">Аска Димаска</option>
                        <option value="ivanov">Иванов Иван</option>
                        <option value="artur">Пироков Артур</option>
                    </select>
                </div>
                <input type="date" class="form-control d-inline" id="scheduleDate">
            </div>

            <!-- Day View -->
            <div id="dayView">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Время</th>
                            <th class="doctor-header" data-doctor="aska">Аска Димаска</th>
                            <th class="doctor-header" data-doctor="ivanov">Иванов Иван</th>
                            <th class="doctor-header" data-doctor="artur">Пироков Артур</th>
                        </tr>
                    </thead>
                    <tbody id="dayScheduleBody">
                        <!-- Day schedule dynamically generated -->
                    </tbody>
                </table>
            </div>

            <!-- Week View -->
            <div id="weekView" style="display: none;">
                <div class="schedule-grid">
                    <div class="day-column">
                        <div class="day-header">9 августа, пн</div>
                        <div class="appointment booked">11:10 - 11:40<br>Ника Ивбуфх</div>
                    </div>
                    <div class="day-column">
                        <div class="day-header">10 августа, вт</div>
                        <div class="appointment confirmed">10:30 - 11:00<br>Камил</div>
                        <div class="appointment pending">11:30 - 12:50<br>Лебедев Виктор</div>
                    </div>
                    <div class="day-column">
                        <div class="day-header">11 августа, ср</div>
                        <div class="appointment booked">13:30 - 14:50<br>Жеребцов Вадим</div>
                    </div>
                    <div class="day-column">
                        <div class="day-header">12 августа, чт</div>
                    </div>
                    <div class="day-column">
                        <div class="day-header">13 августа, пт</div>
                    </div>
                    <div class="day-column">
                        <div class="day-header">14 августа, сб</div>
                    </div>
                    <div class="day-column">
                        <div class="day-header">15 августа, вс</div>
                    </div>
                </div>
            </div>

            <!-- Month View -->
            <div id="monthView" style="display: none;">
                <div class="month-grid">
                    <script>
                        const today = new Date();
                        const year = today.getFullYear();
                        const month = today.getMonth();
                        const daysInMonth = new Date(year, month + 1, 0).getDate();

                        let monthHTML = '';
                        for (let day = 1; day <= daysInMonth; day++) {
                            const visitInfo = day % 2 === 0 ? `<div class="has-visit">1 Визит</div>` : `<div class="no-visit">Визитов нет</div>`;
                            monthHTML += `<div class="month-cell">
                                <div class="month-cell-header">${day} Декабря</div>
                                ${visitInfo}
                            </div>`;
                        }
                        document.write(monthHTML);
                    </script>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('viewSelector').addEventListener('change', function () {
            const selectedView = this.value;
            document.getElementById('dayView').style.display = 'none';
            document.getElementById('weekView').style.display = 'none';
            document.getElementById('monthView').style.display = 'none';

            if (selectedView === 'day') {
                document.getElementById('dayView').style.display = 'block';
            } else if (selectedView === 'week') {
                document.getElementById('weekView').style.display = 'block';
            } else if (selectedView === 'month') {
                document.getElementById('monthView').style.display = 'block';
            }
        });

        const dayScheduleBody = document.getElementById('dayScheduleBody');
        const startTime = 9;
        const endTime = 18;
        const interval = 30;

        for (let hour = startTime; hour < endTime; hour++) {
            for (let min = 0; min < 60; min += interval) {
                const time = `${String(hour).padStart(2, '0')}:${String(min).padStart(2, '0')}`;
                dayScheduleBody.innerHTML += `
                    <tr>
                        <td class="time-column">${time}</td>
                        <td class="appointment" data-doctor="aska">Свободно</td>
                        <td class="appointment" data-doctor="ivanov">Свободно</td>
                        <td class="appointment" data-doctor="artur">Свободно</td>
                    </tr>
                `;
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
