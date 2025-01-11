<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Расписание на месяц</title> 
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

        .schedule-header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .form-select,
        .form-control {
            margin-right: 10px;
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
                <!-- Исправленный переключатель -->
                <label for="viewSelector" class="form-label">Вид расписания:</label>
                <select class="form-select d-inline" id="viewSelector" style="max-width: 200px;" onchange="navigateToView(this.value)">
                    <option value="kalendar.php">На день</option>
                    <option value="week.php">На неделю</option>
                    <option value="month.php" selected>На месяц</option>
                </select>
                <label for="doctorFilter" class="form-label">Фильтр:</label>
                <select class="form-select d-inline" id="doctorFilter" style="max-width: 200px;">
                    <option value="all">Все врачи</option>
                </select>
                <input type="month" id="scheduleDate" class="form-control d-inline" style="max-width: 200px;">
            </div>

            <!-- Month View -->
            <div id="monthView">
                <div class="month-grid" id="monthScheduleBody"></div>
            </div>
        </div>
    </div>

    <script>
        const scheduleDateInput = document.getElementById('scheduleDate');
        const doctorFilter = document.getElementById('doctorFilter');
        const viewSelector = document.getElementById('viewSelector');
        const monthScheduleBody = document.getElementById('monthScheduleBody');
        const monthView = document.getElementById('monthView');
        const today = new Date().toISOString().slice(0, 7); // Формат YYYY-MM

        let monthData = {};

        scheduleDateInput.value = today;

        document.addEventListener('DOMContentLoaded', async () => {
            if (viewSelector.value === 'month.php') {
                await loadMonthlySchedule(scheduleDateInput.value);
            }
        });

        viewSelector.addEventListener('change', () => {
            const selectedView = viewSelector.value;
            navigateToView(selectedView);
        });

        scheduleDateInput.addEventListener('change', async () => {
            if (viewSelector.value === 'month.php') {
                await loadMonthlySchedule(scheduleDateInput.value);
            }
        });

        doctorFilter.addEventListener('change', () => {
            if (viewSelector.value === 'month.php') {
                renderMonthSchedule(monthData);
            }
        });

        async function loadMonthlySchedule(month) {
            try {
                const response = await fetch(`http://localhost:3003/api/patient-cards/schedule/monthly/${month}`);
                monthData = await response.json();
                populateDoctorFilter(monthData);
                renderMonthSchedule(monthData);
            } catch (error) {
                console.error('Ошибка при загрузке расписания на месяц:', error);
                alert('Не удалось загрузить расписание на месяц');
            }
        }

        function populateDoctorFilter(data) {
            doctorFilter.innerHTML = '<option value="all">Все врачи</option>';
            const doctors = new Set();

            Object.values(data).forEach(dateData => {
                Object.keys(dateData).forEach(doctor => {
                    doctors.add(doctor);
                });
            });

            doctors.forEach(doctor => {
                const option = document.createElement('option');
                option.value = doctor;
                option.textContent = doctor;
                doctorFilter.appendChild(option);
            });
        }

        function renderMonthSchedule(data) {
            const filter = doctorFilter.value;
            monthScheduleBody.innerHTML = '';

            const currentMonth = new Date(scheduleDateInput.value);
            const year = currentMonth.getFullYear();
            const month = currentMonth.getMonth();
            const daysInMonth = new Date(year, month + 1, 0).getDate();

            for (let day = 1; day <= daysInMonth; day++) {
                const dateKey = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                const cell = document.createElement('div');
                cell.className = 'month-cell';

                const cellHeader = document.createElement('div');
                cellHeader.className = 'month-cell-header';
                cellHeader.textContent = `${day} ${currentMonth.toLocaleString('default', { month: 'long' })}`;
                cell.appendChild(cellHeader);

                const visitInfo = document.createElement('div');
                visitInfo.className = 'month-cell-visit';

                if (data[dateKey]) {
                    const doctors = filter === 'all' ? Object.keys(data[dateKey]) : [filter];
                    const totalVisits = doctors.reduce((sum, doctor) => sum + (data[dateKey][doctor] || 0), 0);

                    if (totalVisits > 0) {
                        visitInfo.classList.add('has-visit');
                        visitInfo.textContent = `${totalVisits} Визит`;
                    } else {
                        visitInfo.classList.add('no-visit');
                        visitInfo.textContent = 'Визитов нет';
                    }
                } else {
                    visitInfo.classList.add('no-visit');
                    visitInfo.textContent = 'Визитов нет';
                }

                cell.appendChild(visitInfo);
                monthScheduleBody.appendChild(cell);
            }
        }

        function navigateToView(viewUrl) {
            window.location.href = viewUrl;
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
