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
    <?php include 'navbar.php'; ?>

    <div class="container mt-5">
        <!-- Таблица снимков -->
        <div class="table-container">
            <button class="btn btn-primary btn-add" data-bs-toggle="modal" data-bs-target="#addSnapshotModal">Добавить снимок</button>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', async () => {
            const patientCardId = new URLSearchParams(window.location.search).get('patientCardId');
            const token = getCookie('token');

            if (!patientCardId || !token) {
                alert('ID пациента или токен отсутствуют.');
                return;
            }

            // Загрузка снимков
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
                    snapshotsTableBody.innerHTML = data.snapshots.map(snapshot => `
                        <tr>
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
                                <button class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    `).join('');
                } catch (error) {
                    console.error('Ошибка загрузки снимков:', error);
                    alert('Не удалось загрузить снимки.');
                }
            }

            // Предпросмотр снимка
            window.viewSnapshot = function (snapshotFile) {
                const previewImage = document.getElementById('previewImage');
                previewImage.src = snapshotFile;
            };

            // Сохранение нового снимка
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
                        headers: {
                            Authorization: `Bearer ${token}`
                        },
                        body: formData
                    });

                    if (!response.ok) {
                        const textResponse = await response.text();
                        console.error('Ошибка сервера:', textResponse);
                        throw new Error('Ошибка сервера или неправильный ответ');
                    }

                    const result = await response.json();
                    alert(result.message);
                    document.getElementById('snapshotForm').reset();
                    await loadSnapshots();
                } catch (error) {
                    console.error('Ошибка сохранения снимка:', error);
                    alert(`Не удалось сохранить снимок: ${error.message}`);
                }
            }

            document.getElementById('saveSnapshotButton').addEventListener('click', saveSnapshot);
            await loadSnapshots();
        });

        function getCookie(name) {
            const value = `; ${document.cookie}`;
            const parts = value.split(`; ${name}=`);
            if (parts.length === 2) return parts.pop().split(';').shift();
        }
    </script>
</body>
</html>
