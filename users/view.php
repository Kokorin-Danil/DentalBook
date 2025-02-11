<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Профиль пациента | DentalBook</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/jwt-decode@3.1.2/build/jwt-decode.min.js"></script>
</head>
<body>
    <?php include 'profile.php'; ?>
    <?php include '../adminpanel/navbar.php'; ?>

    <div class="container mt-5">
        <!-- Таблица визитов -->
        <div class="table-container">
            <button class="btn btn-primary btn-add" id="addVisitButton" data-bs-toggle="modal" data-bs-target="#addVisitModal">Добавить визит</button>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Дата</th>
                        <th>Время</th>
                        <th>Тип</th>
                        <th>Врач</th>
                        <th>Статус</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody id="visitsTableBody"></tbody>
            </table>
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

    <!-- Модальное окно изменения статуса -->
    <div class="modal fade" id="changeStatusModal" tabindex="-1" aria-labelledby="changeStatusModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changeStatusModalLabel">Изменить статус визита</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                </div>
                <div class="modal-body">
                    <form id="changeStatusForm">
                        <input type="hidden" id="visitIdToUpdate">
                        <div class="mb-3">
                            <label for="visitStatus" class="form-label">Статус визита</label>
                            <select id="visitStatus" class="form-select">
                                <option value="Подтвержден">Подтвержден</option>
                                <option value="Не подтвержден">Не подтвержден</option>
                                <option value="Отменен">Отменен</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                    <button type="button" id="updateStatusButton" class="btn btn-primary">Сохранить изменения</button>
                </div>
            </div>
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
                window.location.replace('/index.php'); // Если истории нет, направляем на auth.php
            }
        }
    }

    checkAccess();
</script>
    <script>
document.addEventListener('DOMContentLoaded', async () => {
    const token = getCookie('token');
    const patientCardId = new URLSearchParams(window.location.search).get('patientCardId');

    let userRole;
    try {
        const decoded = jwt_decode(token);
        userRole = decoded.role;
    } catch (error) {
        console.error("Ошибка декодирования токена:", error);
        alert("Ошибка доступа. Перенаправление на страницу входа.");
        window.location.href = "/login.html";
        return;
    }

    function hideRestrictedElements() {
        if (userRole === "admin" || userRole === "client") {
            document.getElementById('addVisitButton')?.remove();
        }

        if (userRole !== "doctor") {
            document.querySelectorAll('.edit-status-btn').forEach(btn => btn.remove());
        }

        if (userRole !== "admin") {
            document.querySelectorAll('.delete-visit').forEach(btn => btn.remove());
        }
    }

    async function loadVisits() {
        const response = await fetch(`http://localhost:3003/api/patient-cards/visit/all/${patientCardId}`, {
            headers: { Authorization: `Bearer ${token}` }
        });

        const data = await response.json();
        data.visits.sort((a, b) => new Date(`${a.visitDate}T${a.visitTime}`) - new Date(`${b.visitDate}T${b.visitTime}`));

        const tableBody = document.getElementById('visitsTableBody');
        tableBody.innerHTML = data.visits.map(visitToHTML).join('');
        hideRestrictedElements();
    }

    function visitToHTML(visit) {
        const formattedStatus = visit.visitStatus.charAt(0).toUpperCase() + visit.visitStatus.slice(1);
        return `
            <tr id="visit-${visit.id}">
                <td>${visit.id}</td>
                <td>${visit.visitDate}</td>
                <td>${visit.visitTime}</td>
                <td>${visit.visitType}</td>
                <td>${visit.doctor ? visit.doctor.lastName + " " + visit.doctor.firstName : 'Не указано'}</td>
                <td id="status-${visit.id}">${formattedStatus}</td>
                <td>
                    ${userRole === "doctor" ? `
                        <button class="btn btn-sm btn-warning edit-status-btn" onclick="openChangeStatusModal(${visit.id}, '${visit.visitStatus}')">
                            <i class="fas fa-edit"></i>
                        </button>
                    ` : ''}
                </td>
            </tr>
        `;
    }

    async function updateVisitStatus() {
        const visitId = document.getElementById('visitIdToUpdate').value;
        const newStatus = document.getElementById('visitStatus').value;

        try {
            const response = await fetch(`http://localhost:3003/api/patient-cards/visit/change/${visitId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    Authorization: `Bearer ${token}`
                },
                body: JSON.stringify({ newStatus: newStatus })
            });

            if (!response.ok) throw new Error('Ошибка при обновлении статуса.');

            document.getElementById(`status-${visitId}`).textContent = newStatus;

            alert('Статус успешно обновлен!');
        } catch (error) {
            console.error('Ошибка обновления статуса:', error);
            alert('Не удалось обновить статус визита.');
        }
    }

    async function saveVisit() {
        if (userRole !== "doctor") {
            alert("У вас нет прав для добавления визита.");
            return;
        }

        const visitData = {
            patientCardId: document.getElementById('patientSelect').value,
            doctorFullName: document.getElementById('doctorSelect').value,
            visitType: document.getElementById('visitType').value,
            visitDate: document.getElementById('visitDate').value,
            visitTime: document.getElementById('visitTime').value
        };

        try {
            const response = await fetch('http://localhost:3003/api/patient-cards/visit/create', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    Authorization: `Bearer ${token}`
                },
                body: JSON.stringify(visitData)
            });

            if (!response.ok) throw new Error('Ошибка при добавлении визита.');

            alert('Визит успешно добавлен!');
            document.getElementById('visitForm').reset();
            await loadVisits();
        } catch (error) {
            console.error('Ошибка сохранения визита:', error);
            alert(error.message);
        }
    }

    async function populateDoctors() {
        try {
            const response = await fetch('http://localhost:3003/api/patient-cards/get/all/doctors', {
                headers: { Authorization: `Bearer ${token}` }
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

    async function populatePatients() {
        try {
            const response = await fetch('http://localhost:3003/api/patient-cards/get/all', {
                headers: { Authorization: `Bearer ${token}` }
            });

            if (!response.ok) throw new Error('Ошибка загрузки пациентов');

            const patients = await response.json();
            const patientSelect = document.getElementById('patientSelect');
            patientSelect.innerHTML = '';

            patients.forEach(patient => {
                const option = document.createElement('option');
                option.value = patient.id;
                option.textContent = `${patient.fullName} (Дата рождения: ${new Date(patient.dateOfBirth).toLocaleDateString()})`;
                patientSelect.appendChild(option);
            });
        } catch (error) {
            console.error('Ошибка загрузки пациентов:', error);
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

    document.getElementById('saveVisitButton')?.addEventListener('click', saveVisit);
    document.getElementById('updateStatusButton')?.addEventListener('click', updateVisitStatus);

    await loadVisits();
    await populateDoctors();
    await populatePatients();
    populateTimeIntervals();
});

function openChangeStatusModal(visitId, currentStatus) {
    document.getElementById('visitIdToUpdate').value = visitId;
    document.getElementById('visitStatus').value = currentStatus;
    const modal = new bootstrap.Modal(document.getElementById('changeStatusModal'));
    modal.show();
}

function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
}


</script>

</body>
</html>
