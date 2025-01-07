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

        .appointment.available {
            background-color: #d1e7dd;
        }

        .appointment.booked {
            background-color: #f8d7da;
        }

        .current-date {
            margin-bottom: 20px;
            font-size: 1.2rem;
            font-weight: bold;
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

        <div class="current-date" id="currentDate">Сегодня: </div>

        <div class="schedule-container">
            <div class="schedule-header mb-3">
                <label for="scheduleDate" class="form-label">Выберите дату:</label>
                <input type="date" id="scheduleDate" class="form-control d-inline" style="max-width: 200px; margin-right: 10px;">
                <label for="doctorFilter" class="form-label">Выберите врача:</label>
                <select class="form-select d-inline" id="doctorFilter" style="max-width: 200px;">
                    <option value="all">Все врачи</option>
                    <!-- Опции врачей добавляются динамически -->
                </select>
            </div>

            <table class="table">
                <thead>
                    <tr id="tableHeader">
                        <th>Время</th>
                        <!-- Врачи добавляются динамически -->
                    </tr>
                </thead>
                <tbody id="scheduleTableBody">
                    <!-- Данные будут загружены динамически -->
                </tbody>
            </table>
        </div>
    </div>

    <script>
    const scheduleTableBody = document.getElementById('scheduleTableBody');
    const tableHeader = document.getElementById('tableHeader');
    const scheduleDateInput = document.getElementById('scheduleDate');
    const doctorFilter = document.getElementById('doctorFilter');
    const today = new Date().toISOString().split('T')[0]; // Получаем текущую дату в формате YYYY-MM-DD

    let scheduleData = {}; // Переменная для хранения расписания

    // Устанавливаем текущую дату в поле выбора даты
    scheduleDateInput.value = today;

    // Загружаем расписание при загрузке страницы
    document.addEventListener('DOMContentLoaded', async () => {
        await loadSchedule(today);
    });

    // Событие изменения даты
    scheduleDateInput.addEventListener('change', async () => {
        const selectedDate = scheduleDateInput.value;

        if (!selectedDate) {
            alert('Выберите дату для отображения расписания');
            return;
        }

        await loadSchedule(selectedDate);
    });

    // Событие изменения фильтра врачей
    doctorFilter.addEventListener('change', () => {
        const filteredDoctor = doctorFilter.value;
        renderSchedule(scheduleData, filteredDoctor);
    });

    // Функция загрузки расписания
    async function loadSchedule(date) {
        try {
            const response = await fetch(`http://localhost:3003/api/patient-cards/schedule/${date}`);
            scheduleData = await response.json();

            populateDoctorFilter(scheduleData);
            renderSchedule(scheduleData);
        } catch (error) {
            console.error('Ошибка при загрузке расписания:', error);
            alert('Не удалось загрузить расписание');
        }
    }

    // Функция заполнения фильтра врачей
    function populateDoctorFilter(data) {
        doctorFilter.innerHTML = '<option value="all">Все врачи</option>';
        Object.keys(data).forEach(doctor => {
            const doctorName = doctor.split('-')[1];
            const option = document.createElement('option');
            option.value = doctor;
            option.textContent = doctorName;
            doctorFilter.appendChild(option);
        });
    }

    // Функция рендеринга расписания
    function renderSchedule(data, filter = 'all') {
        // Очистить предыдущие данные
        scheduleTableBody.innerHTML = '';
        tableHeader.innerHTML = '<th>Время</th>';

        // Получаем список врачей
        const doctors = filter === 'all' ? Object.keys(data) : [filter];

        // Добавляем врачей в заголовок таблицы
        doctors.forEach(doctor => {
            const doctorName = doctor.split('-')[1];
            const th = document.createElement('th');
            th.textContent = doctorName;
            tableHeader.appendChild(th);
        });

        // Генерируем расписание
        const times = data[Object.keys(data)[0]].map(item => item.time); // Времена из расписания первого врача
        times.forEach(time => {
            const row = document.createElement('tr');
            const timeCell = document.createElement('td');
            timeCell.textContent = time;
            row.appendChild(timeCell);

            doctors.forEach(doctor => {
                const doctorSchedule = data[doctor]?.find(item => item.time === time) || {};
                const cell = document.createElement('td');
                cell.textContent = doctorSchedule.status === 'available' ? 'Свободно' : 'Забронировано';
                cell.className = `appointment ${doctorSchedule.status || ''}`;
                row.appendChild(cell);
            });

            scheduleTableBody.appendChild(row);
        });
    }
</script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
