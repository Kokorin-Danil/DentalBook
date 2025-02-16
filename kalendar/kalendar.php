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
    </style>
</head>
<body>
<?php include '../adminpanel/navbar.php'; ?>

    <div class="main-content">
        <div class="header">
            <h2>Расписание</h2>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addVisitModal">Новый визит</button>
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

     <!-- Модальное окно добавления визита -->
     <div class="modal fade" id="addVisitModal" tabindex="-1" aria-labelledby="addVisitModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addVisitModalLabel">Новый визит</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                </div>
                <div class="modal-body">
                    <form id="visitForm">
                        <div class="mb-3">
                            <label for="patientSelect" class="form-label">Пациент</label>
                            <select id="patientSelect" class="form-select" required></select>
                        </div>
                        <div class="mb-3">
                            <label for="doctorSelect" class="form-label">Выберите врача</label>
                            <select id="doctorSelect" class="form-select" required>
                                <!-- Врачи будут загружены динамически -->
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="visitType" class="form-label">Тип визита</label>
                            <select id="visitType" class="form-select" required>
                                <option value="осмотр" selected>Осмотр</option>
                                <option value="лечение">Лечение</option>
                                <option value="консультация">Консультация</option>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="visitDate" class="form-label">Дата визита</label>
                                <input type="date" id="visitDate" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="visitTime" class="form-label">Время визита</label>
                                <select id="visitTime" class="form-select" required></select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                    <button type="button" id="saveVisitButton" class="btn btn-primary">Сохранить</button>
                </div>
            </div>
        </div>
    </div>
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

        if (!['manager', 'doctor'].includes(userRole)) {
            alert('У вас нет доступа к этой странице!');
            if (document.referrer) {
                window.location.href = document.referrer; // Возвращаем на предыдущую страницу
            } else {
                window.location.replace('/index.php'); // Если истории нет, направляем на auth.php
            }
        }
    }

    checkAccess();
</script>

<script>
    const scheduleTableBody = document.getElementById('scheduleTableBody');
    const tableHeader = document.getElementById('tableHeader');
    const scheduleDateInput = document.getElementById('scheduleDate');
    const doctorFilter = document.getElementById('doctorFilter');
    const viewSelector = document.getElementById('viewSelector');
    const saveVisitButton = document.getElementById('saveVisitButton');
    const visitForm = document.getElementById('visitForm');
    const today = new Date().toISOString().split('T')[0];

    let scheduleData = {};
    scheduleDateInput.value = today;

    document.addEventListener('DOMContentLoaded', async () => {
        await loadSchedule(today);
        await populateDoctors();
        await populatePatients();
        populateTimeIntervals();
    });

    scheduleDateInput.addEventListener('change', async () => {
        await loadSchedule(scheduleDateInput.value);
    });

    doctorFilter.addEventListener('change', () => {
        renderDaySchedule(scheduleData);
    });

    viewSelector.addEventListener('change', () => {
        const selectedView = viewSelector.value;
        if (selectedView === 'week') {
            window.location.href = '/kalendar/week.php';
        } else if (selectedView === 'month') {
            window.location.href = '/kalendar/month.php';
        }
    });

    saveVisitButton.addEventListener('click', async () => {
        const visitData = {
            patientCardId: document.getElementById('patientSelect').value,
            doctorFullName: document.getElementById('doctorSelect').value,
            visitType: document.getElementById('visitType').value,
            visitDate: document.getElementById('visitDate').value,
            visitTime: document.getElementById('visitTime').value + ':00'
        };

        try {
            const response = await fetch('http://localhost:3003/api/patient-cards/visit/create', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    Authorization: `Bearer ${getCookie('token')}`
                },
                body: JSON.stringify(visitData)
            });

            if (!response.ok) {
                const error = await response.json();
                throw new Error(error.message || 'Ошибка при добавлении визита');
            }

            alert('Визит успешно добавлен!');
            visitForm.reset();
            await loadSchedule(scheduleDateInput.value);
        } catch (error) {
            alert(`Ошибка: ${error.message}`);
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

    async function populatePatients() {
        const response = await fetch('http://localhost:3003/api/patient-cards/get/all', {
            headers: { Authorization: `Bearer ${getCookie('token')}` }
        });
        const patients = await response.json();
        const patientSelect = document.getElementById('patientSelect');
        patientSelect.innerHTML = '';

        patients.forEach(patient => {
            const option = document.createElement('option');
            option.value = patient.id;
            option.textContent = `${patient.fullName} (Дата рождения: ${new Date(patient.dateOfBirth).toLocaleDateString()})`;
            patientSelect.appendChild(option);
        });
    }

    async function populateDoctors() {
        try {
            const response = await fetch('http://localhost:3003/api/patient-cards/get/all/doctors', {
                headers: { Authorization: `Bearer ${getCookie('token')}` }
            });

            if (!response.ok) {
                throw new Error('Ошибка загрузки списка врачей');
            }

            const doctors = await response.json();
            const doctorSelect = document.getElementById('doctorSelect');
            doctorSelect.innerHTML = '';

            doctors.forEach(doctor => {
                const option = document.createElement('option');
                option.value = doctor.fullName;
                option.textContent = `${doctor.fullName} (${doctor.specialty})`;
                doctorSelect.appendChild(option);
            });
        } catch (error) {
            console.error('Ошибка загрузки врачей:', error);
            alert('Не удалось загрузить список врачей.');
        }
    }

    function populateTimeIntervals() {
        const visitTimeSelect = document.getElementById('visitTime');
        visitTimeSelect.innerHTML = '';

        const startTime = new Date('1970-01-01T09:00:00');
        const endTime = new Date('1970-01-01T17:30:00');

        while (startTime <= endTime) {
            const option = document.createElement('option');
            option.value = startTime.toTimeString().substring(0, 5);
            option.textContent = startTime.toTimeString().substring(0, 5);
            visitTimeSelect.appendChild(option);
            startTime.setMinutes(startTime.getMinutes() + 30);
        }
    }

    function getCookie(name) {
        const value = `; ${document.cookie}`;
        const parts = value.split(`; ${name}=`);
        if (parts.length === 2) return parts.pop().split(';').shift();
    }
</script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
