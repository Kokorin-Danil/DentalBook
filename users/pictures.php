<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Снимки пациента | DentalBook</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'profile.php'; ?>
    <?php include '../adminpanel/navbar.php'; ?>

    <div class="main-content">
        <!-- Таблица снимков -->
        <div class="table-container">
            <button class="btn btn-primary btn-add" id="addSnapshotButton" data-bs-toggle="modal" data-bs-target="#addSnapshotModal">Добавить снимок</button>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Дата</th>
                        <th>Зубы</th>
                        <th>Описание</th>
                        <th>Снимок</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody id="snapshotsTableBody">
                    <!-- Данные снимков будут загружены динамически -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Модальное окно добавления снимка -->
    <div class="modal fade" id="addSnapshotModal" tabindex="-1" aria-labelledby="addSnapshotModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Заголовок модального окна -->
                <div class="modal-header">
                    <h5 class="modal-title" id="addSnapshotModalLabel">Новый снимок</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                </div>

                <!-- Тело модального окна -->
                <div class="modal-body">
                    <form id="snapshotForm">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="snapshotVisit" class="form-label">Визит</label>
                                <input type="text" id="snapshotVisit" class="form-control" placeholder="Введите номер визита" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="snapshotTeeth" class="form-label">Зубы</label>
                                <input type="text" id="snapshotTeeth" class="form-control" placeholder="Введите номера зубов" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="snapshotDescription" class="form-label">Описание</label>
                                <textarea id="snapshotDescription" class="form-control" placeholder="Введите описание" required></textarea>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="snapshotFile" class="form-label">Снимок</label>
                                <input type="file" id="snapshotFile" class="form-control" required>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Подвал модального окна -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                    <button type="button" id="saveSnapshotButton" class="btn btn-primary">Сохранить</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Модальное окно предварительного просмотра снимка -->
    <div class="modal fade" id="viewSnapshotModal" tabindex="-1" aria-labelledby="viewSnapshotModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewSnapshotModalLabel">Предпросмотр снимка</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="previewImage" src="" alt="Снимок" class="img-fluid">
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

        if (!['admin', 'doctor', 'client'].includes(userRole)) {
            alert('У вас нет доступа к этой странице!');
            if (document.referrer) {
                window.location.href = document.referrer; // Возвращаем на предыдущую страницу
            } else {
                window.location.replace('/auth.php'); // Если истории нет, направляем на auth.php
            }
        }
    }

// Функция проверки доступа к карте пациента
async function checkPatientAccess(token, patientCardId) {
    try {
        const response = await fetch(`http://localhost:3003/api/users/check/${patientCardId}`, {
            headers: { Authorization: `Bearer ${token}` }
        });

        if (response.status === 403) {
            alert('У вас нет доступа к этой карте пациента.');
            if (document.referrer) {
                window.location.href = document.referrer; // Возвращает на предыдущую страницу
            } else {
                window.location.href = '/index.php'; // Перенаправляет на страницу авторизации
            }
            return false;
        }

        return true;
    } catch (error) {
        console.error('Ошибка проверки доступа:', error);
        alert('Ошибка при проверке доступа. Попробуйте снова.');
        return false;
    }
}

document.addEventListener('DOMContentLoaded', async () => {
    const token = getCookie('token');
    const patientCardId = new URLSearchParams(window.location.search).get('patientCardId');

    if (!token || !patientCardId) {
        alert("Ошибка доступа. Перенаправление на страницу входа.");
        window.location.href = "/index.php";
        return;
    }

    // Проверяем доступ пользователя к карте пациента
    const hasAccess = await checkPatientAccess(token, patientCardId);
    if (!hasAccess) return;

    let userRole;
    try {
        const decoded = jwt_decode(token);
        userRole = decoded.role;
    } catch (error) {
        console.error("Ошибка декодирования токена:", error);
        alert("Ошибка доступа. Перенаправление на страницу входа.");
        window.location.href = "/index.php";
        return;
    }

    await loadVisits();
    await populateDoctors();
    await populatePatients();
    populateTimeIntervals();
});
    
    checkAccess();
</script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', async () => {
        const patientCardId = new URLSearchParams(window.location.search).get('patientCardId');
        const token = getCookie('token');

        if (!patientCardId || !token) {
            alert('ID пациента или токен отсутствуют.');
            return;
        }

        // Проверка роли пользователя в токене
        const role = getRoleFromToken(token);
        if (role === "admin" || role === "client") {
            // Скрываем кнопку "Добавить снимок" для клиента
            const addSnapshotButton = document.getElementById('addSnapshotButton');
            if (addSnapshotButton) {
                addSnapshotButton.style.display = 'none';
            }
        }

        async function loadSnapshots() {
            try {
                const response = await fetch(`http://localhost:3003/api/patient-cards/snapshots/getall/${patientCardId}`, {
                    headers: { Authorization: `Bearer ${token}` }
                });

                if (!response.ok) {
                    throw new Error('Ошибка загрузки снимков');
                }

                const data = await response.json();
                const snapshotsTableBody = document.getElementById('snapshotsTableBody');
                const errorMessage = document.getElementById('errorMessage');

                // Если снимков нет, очищаем таблицу, но не показываем ошибку
                if (!data.snapshots || data.snapshots.length === 0) {
                    snapshotsTableBody.innerHTML = '<tr><td colspan="6" class="text-center text-muted">Снимки отсутствуют</td></tr>';
                    errorMessage.style.display = 'none';
                    return;
                }

                // Заполняем таблицу снимками
                snapshotsTableBody.innerHTML = data.snapshots.map(snapshot => `
                    <tr id="snapshot-${snapshot.id}">
                        <td>${snapshot.id}</td>
                        <td>${new Date(snapshot.createdAt).toLocaleDateString()}</td>
                        <td>${snapshot.toothNumbers}</td>
                        <td>${snapshot.note}</td>
                        <td>
                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#viewSnapshotModal" onclick="viewSnapshot('${snapshot.snapshotFile}')">
                                Посмотреть
                            </button>
                        </td>
                        <td>
                            ${role === 'admin' ? `<button class="btn btn-sm btn-danger" onclick="deleteSnapshot(${snapshot.id})"><i class="fas fa-trash"></i></button>` : ''}
                        </td>
                    </tr>
                `).join('');

                errorMessage.style.display = 'none';
            } catch (error) {
                console.error('Ошибка загрузки снимков:', error);
                document.getElementById('errorMessage').textContent = 'Не удалось загрузить снимки.';
                document.getElementById('errorMessage').style.display = 'block';
            }
        }

        window.viewSnapshot = function (snapshotFile) {
            document.getElementById('previewImage').src = snapshotFile;
        };

        async function saveSnapshot() {
            const visit = document.getElementById('snapshotVisit').value;
            const teeth = document.getElementById('snapshotTeeth').value;
            const description = document.getElementById('snapshotDescription').value;
            const file = document.getElementById('snapshotFile').files[0];

            if (!visit || !teeth || !description || !file) {
                alert('Пожалуйста, заполните все поля и выберите файл.');
                return;
            }

            const formData = new FormData();
            formData.append('patientCardId', patientCardId);
            formData.append('visitId', visit);
            formData.append('toothNumbers', teeth);
            formData.append('note', description);
            formData.append('snapshots', file);

            try {
                const response = await fetch('http://localhost:3003/api/patient-cards/snapshots/create', {
                    method: 'POST',
                    headers: { Authorization: `Bearer ${token}` },
                    body: formData
                });

                if (!response.ok) {
                    throw new Error('Ошибка сервера');
                }

                alert('Снимок успешно добавлен.');
                document.getElementById('snapshotForm').reset();
                await loadSnapshots();
            } catch (error) {
                console.error('Ошибка сохранения снимка:', error);
            }
        }

        document.getElementById('saveSnapshotButton').addEventListener('click', saveSnapshot);
        await loadSnapshots();
    });

    function getCookie(name) {
        const value = `; ${document.cookie}`;
        const parts = value.split(`; ${name}=`);
        return parts.length === 2 ? parts.pop().split(';').shift() : null;
    }

    function getRoleFromToken(token) {
        try {
            const payload = JSON.parse(atob(token.split('.')[1]));
            return payload.role;
        } catch (error) {
            console.error('Ошибка декодирования токена:', error);
            return null;
        }
    }

    async function deleteSnapshot(snapshotId) {
        if (!confirm('Вы уверены, что хотите удалить этот снимок?')) return;

        try {
            await fetch(`http://localhost:3003/api/admin/snapshot/${snapshotId}`, {
                method: 'DELETE',
                headers: { Authorization: `Bearer ${getCookie('token')}` }
            });

            document.getElementById(`snapshot-${snapshotId}`).remove();
            alert('Снимок успешно удален.');
        } catch (error) {
            alert('Не удалось удалить снимок.');
        }
    }
</script>


</body>
</html>
