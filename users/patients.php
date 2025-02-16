<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Пациенты | DentalBook</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        #content {
            margin: 20px;
            background-color: #f8f9fa;
            min-height: 100vh;
        }
        .table-actions button {
            margin-right: 5px;
        }
        .search-bar {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        .search-bar input {
            flex: 1;
            margin-right: 10px;
        }
        .search-bar .fa-search {
            position: relative;
            left: -30px;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <?php include '../adminpanel/navbar.php'; ?>

    <div id="content">
        <div class="main-content">
            <h2 class="mb-4">Пациенты</h2>

            <div class="search-bar">
                <a href="/users/createcardpatient.php" class="btn btn-success ms-2"><i class="fas fa-plus"></i> Добавить пациента</a>
            </div>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Номер карты</th>
                        <th>ФИО</th>
                        <th>Телефон</th>
                        <th>Дата рождения</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody id="patientTableBody">
                    <!-- Данные будут загружены динамически -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Модальное окно для подтверждения удаления -->
    <div class="modal fade" id="deletePatientModal" tabindex="-1" aria-labelledby="deletePatientModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deletePatientModalLabel">Подтверждение удаления</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Вы уверены, что хотите удалить эту карту пациента?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteButton">Удалить</button>
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

        if (!['admin', 'doctor'].includes(userRole)) {
            alert('У вас нет доступа к этой странице!');
            if (document.referrer) {
                window.location.href = document.referrer; // Возвращаем на предыдущую страницу
            } else {
                window.location.replace('/index.php'); // Если истории нет, направляем на index.php
            }
        }
    }

    checkAccess();
</script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const token = getCookie('token');

            if (!token) return;

            const role = getRoleFromToken(token);

            if (role === "admin") {
                const addPatientButton = document.querySelector('.btn-success.ms-2');
                if (addPatientButton) {
                    addPatientButton.style.display = 'none';
                }
            }
        });

        function getRoleFromToken(token) {
            try {
                const payload = JSON.parse(atob(token.split('.')[1]));
                return payload.role;
            } catch (error) {
                console.error('Ошибка декодирования токена:', error);
                return null;
            }
        }
        
        let patientIdToDelete = null;

        function getCookie(name) {
            const value = `; ${document.cookie}`;
            const parts = value.split(`; ${name}=`);
            if (parts.length === 2) return parts.pop().split(';').shift();
        }

        async function loadPatients() {
            const token = getCookie('token');
            if (!token) {
                alert('Токен не найден. Выполните вход заново.');
                window.location.href = '/auth.php';
                return;
            }

            try {
                const response = await fetch('http://localhost:3003/api/patient-cards/get/all', {
                    method: 'GET',
                    headers: {
                        Authorization: `Bearer ${token}`
                    }
                });

                if (!response.ok) {
                    throw new Error('Ошибка загрузки данных пациентов');
                }

                const patients = await response.json();
                populatePatientTable(patients);
            } catch (error) {
                console.error('Ошибка:', error);
                alert('Не удалось загрузить данные пациентов.');
            }
        }

        function populatePatientTable(patients) {
            const tableBody = document.getElementById('patientTableBody');
            tableBody.innerHTML = '';

            patients.forEach((patient) => {
                const lastVisitDate = patient.lastVisit ? new Date(patient.lastVisit) : null;
                const lastVisitDisplay = lastVisitDate ? lastVisitDate.toLocaleDateString() + ' ' + lastVisitDate.toLocaleTimeString() : 'Нет записей';
                const dateOfBirthDisplay = new Date(patient.dateOfBirth).toLocaleDateString();

                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${patient.id}</td>
                    <td>${patient.fullName}</td>
                    <td>${patient.phoneNumber}</td>
                    <td>${dateOfBirthDisplay}</td>

                    <td class="table-actions">
                        <a href="/users/view.php?patientCardId=${patient.id}" class="btn btn-sm btn-info">
                            <i class="fas fa-eye"></i> Просмотреть
                        </a>
                        <button class="btn btn-sm btn-danger delete-patient" data-id="${patient.id}">
                            <i class="fas fa-trash"></i> Удалить
                        </button>
                    </td>
                `;

                tableBody.appendChild(row);
            });

            document.querySelectorAll('.delete-patient').forEach(button => {
                button.addEventListener('click', (event) => {
                    patientIdToDelete = button.getAttribute('data-id');
                    const deleteModal = new bootstrap.Modal(document.getElementById('deletePatientModal'));
                    deleteModal.show();
                });
            });
        }

        async function deletePatient() {
            const token = getCookie('token');
            if (!token) {
                alert('Токен не найден. Выполните вход заново.');
                return;
            }

            try {
                const response = await fetch(`http://localhost:3003/api/patient-cards/card/${patientIdToDelete}`, {
                    method: 'DELETE',
                    headers: {
                        Authorization: `Bearer ${token}`
                    }
                });

                if (!response.ok) {
                    throw new Error('Ошибка удаления карты пациента');
                }

                alert('Карта пациента успешно удалена.');
                loadPatients();
            } catch (error) {
                console.error('Ошибка:', error);
                alert('Не удалось удалить карту пациента.');
            }
        }

        document.getElementById('confirmDeleteButton').addEventListener('click', () => {
            deletePatient();
            const deleteModal = bootstrap.Modal.getInstance(document.getElementById('deletePatientModal'));
            deleteModal.hide();
        });

        document.addEventListener('DOMContentLoaded', loadPatients);
    </script>
</body>
</html>
