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
    <?php include 'navbar.php'; ?>

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
                            <label for="doctorFullName" class="form-label">ФИО врача</label>
                            <input type="text" id="doctorFullName" class="form-control" placeholder="Введите ФИО врача" required>
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
    <script>
    document.addEventListener('DOMContentLoaded', async () => {
        const token = getCookie('token');
        const patientCardId = new URLSearchParams(window.location.search).get('patientCardId');

        function populateTimeIntervals() {
            const visitTimeSelect = document.getElementById('visitTime');
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

        async function populatePatients() {
            const response = await fetch('http://localhost:3003/api/patient-cards/get/all', {
                headers: { Authorization: `Bearer ${token}` }
            });
            const patients = await response.json();
            const patientSelect = document.getElementById('patientSelect');
            patients.forEach(patient => {
                const option = document.createElement('option');
                option.value = patient.id;
                option.textContent = `${patient.fullName} (Дата рождения: ${new Date(patient.dateOfBirth).toLocaleDateString()})`;
                patientSelect.appendChild(option);
            });
        }

        async function loadVisits() {
            const response = await fetch(`http://localhost:3003/api/patient-cards/visit/all/${patientCardId}`, {
                headers: { Authorization: `Bearer ${token}` }
            });
            const data = await response.json();
            const tableBody = document.getElementById('visitsTableBody');
            tableBody.innerHTML = data.visits.map(visitToHTML).join('');
        }

        function visitToHTML(visit) {
            return `
                <tr id="visit-${visit.id}">
                    <td>${visit.id}</td>
                    <td>${visit.visitDate}</td>
                    <td>${visit.visitTime}</td>
                    <td>${visit.visitType}</td>
                    <td>${visit.doctor?.lastName ?? ''} ${visit.doctor?.firstName ?? ''} ${visit.doctor?.patronymic ?? ''}</td>
                    <td id="status-${visit.id}">${visit.visitStatus}</td>
                    <td>
                        <button class="btn btn-sm btn-warning" onclick="openChangeStatusModal(${visit.id}, '${visit.visitStatus}')">
                            <i class="fas fa-edit"></i>
                        </button>
                    </td>
                </tr>
            `;
        }

        async function saveVisit() {
            const visitData = {
                patientCardId: document.getElementById('patientSelect').value,
                doctorFullName: document.getElementById('doctorFullName').value,
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

                const { visit: newVisit } = await response.json();
                const tableBody = document.getElementById('visitsTableBody');
                tableBody.insertAdjacentHTML('beforeend', visitToHTML(newVisit));

                alert('Визит успешно добавлен!');
                bootstrap.Modal.getInstance(document.getElementById('addVisitModal')).hide();
                document.getElementById('visitForm').reset();
            } catch (error) {
                alert(error.message);
            }
        }

        async function updateVisitStatus() {
            const visitId = document.getElementById('visitIdToUpdate').value;
            const newStatus = document.getElementById('visitStatus').value;
            const response = await fetch(`http://localhost:3003/api/patient-cards/visit/change/${visitId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    Authorization: `Bearer ${token}`
                },
                body: JSON.stringify({ newStatus })
            });

            if (response.ok) {
                document.getElementById(`status-${visitId}`).textContent = newStatus;
                bootstrap.Modal.getInstance(document.getElementById('changeStatusModal')).hide();
                alert('Статус визита успешно обновлен!');
            } else {
                alert('Ошибка при обновлении статуса.');
            }
        }

        document.getElementById('saveVisitButton').addEventListener('click', saveVisit);
        document.getElementById('updateStatusButton').addEventListener('click', updateVisitStatus);
        await loadVisits();
        populateTimeIntervals();
        await populatePatients();
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
