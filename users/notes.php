<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Примечания | DentalBook</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'profile.php'; ?>
    <?php include '../adminpanel/navbar.php'; ?>

    <div class="main-content">
        <!-- Таблица примечаний -->
        <div class="table-container">
            <button class="btn btn-primary btn-add" id="addNoteButton" data-bs-toggle="modal" data-bs-target="#addNoteModal">Добавить примечание</button>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Имя</th>
                        <th>Описание</th>
                        <th>Важность</th>
                        <th>Врач</th>
                        <th>Дата создания</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody id="notesTableBody">
                    <!-- Данные примечаний будут загружены динамически -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Модальное окно -->
    <div class="modal fade" id="addNoteModal" tabindex="-1" aria-labelledby="addNoteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Заголовок модального окна -->
                <div class="modal-header">
                    <h5 class="modal-title" id="addNoteModalLabel">Новое примечание</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                </div>

                <!-- Тело модального окна -->
                <div class="modal-body">
                    <form id="noteForm">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="noteName" class="form-label">Имя примечания</label>
                                <input type="text" id="noteName" class="form-control" placeholder="Введите имя примечания" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="noteDescription" class="form-label">Описание</label>
                                <textarea id="noteDescription" class="form-control" placeholder="Введите описание" required></textarea>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="notePriority" class="form-label">Важность</label>
                                <select id="notePriority" class="form-select" required>
                                    <option value="Высокая">Высокая</option>
                                    <option value="Средняя">Средняя</option>
                                    <option value="Низкая">Низкая</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Подвал модального окна -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                    <button type="button" id="saveNoteButton" class="btn btn-primary">Сохранить</button>
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
                window.location.replace('/index.php'); // Если истории нет, направляем на index.php
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
    <script>
// Проверка роли из токена и скрытие элементов (кнопки и столбцы)
function checkRoleAndHideElements() {
    const token = getCookie('token');

    if (!token) {
        console.error('Ошибка: Токен не найден!');
        return;
    }

    try {
        const payload = JSON.parse(atob(token.split('.')[1])); // Расшифровка токена
        const userRole = payload.role;

        console.log("Роль пользователя:", userRole); // Логируем роль для проверки

        // Скрываем кнопку "Добавить примечание" для admin и client
        const addNoteButton = document.getElementById('addNoteButton');
        if (addNoteButton && (userRole === 'admin' || userRole === 'client')) {
            addNoteButton.style.display = 'none';
        }

        // Скрываем столбец "Действия" и кнопки удаления примечаний для doctor и client
        if (userRole === "doctor" || userRole === 'client') {
            document.querySelectorAll("td:last-child, th:last-child").forEach(el => {
                el.style.display = "none";
            });
        }

    } catch (error) {
        console.error('Ошибка декодирования токена:', error);
    }
}

// Функция получения токена из cookies
function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    return parts.length === 2 ? parts.pop().split(';').shift() : null;
}

// Функция загрузки примечаний
async function loadNotes() {
    const patientCardId = new URLSearchParams(window.location.search).get('patientCardId');
    const token = getCookie('token');

    if (!patientCardId || !token) {
        alert('Ошибка: ID пациента или токен отсутствуют.');
        return;
    }

    try {
        const response = await fetch(`http://localhost:3003/api/patient-cards/notes/getall/${patientCardId}`, {
            headers: { Authorization: `Bearer ${token}` },
        });

        if (!response.ok) {
            throw new Error('Ошибка загрузки примечаний');
        }

        const data = await response.json();
        const notesTableBody = document.getElementById('notesTableBody');
        notesTableBody.innerHTML = data.notes.map(note => `
            <tr id="note-${note.id}">
                <td>${note.id}</td>
                <td>${note.name}</td>
                <td>${note.description}</td>
                <td class="${note.importance === 'Высокая' ? 'text-danger' : note.importance === 'Средняя' ? 'text-warning' : 'text-success'}">${note.importance}</td>
                <td>${note.doctor.firstName} ${note.doctor.lastName}</td>
                <td>${new Date(note.createdAt).toLocaleDateString()}</td>
                <td>
                    <button class="btn btn-sm btn-danger delete-note-btn" onclick="deleteNote(${note.id})">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
        `).join('');

        // Проверяем роль и скрываем кнопки удаления после загрузки примечаний
        checkRoleAndHideElements();
    } catch (error) {
        console.error('Ошибка загрузки примечаний:', error);
    }
}

// Функция удаления примечания
async function deleteNote(noteId) {
    const token = getCookie('token');
    if (!token) {
        alert('Необходима авторизация администратора.');
        return;
    }

    if (!confirm('Вы уверены, что хотите удалить это примечание?')) return;

    try {
        const response = await fetch(`http://localhost:3003/api/admin/patientNote/${noteId}`, {
            method: 'DELETE',
            headers: { Authorization: `Bearer ${token}` },
        });

        if (!response.ok) {
            throw new Error(`Ошибка HTTP: ${response.status}`);
        }

        document.getElementById(`note-${noteId}`).remove();
        alert('Примечание успешно удалено.');
    } catch (error) {
        console.error('Ошибка удаления примечания:', error);
        alert('Не удалось удалить примечание.');
    }
}

// Сохранение нового примечания
document.getElementById('saveNoteButton').addEventListener('click', async () => {
    const patientCardId = new URLSearchParams(window.location.search).get('patientCardId');
    const token = getCookie('token');

    if (!patientCardId || !token) {
        alert('Ошибка: ID пациента или токен отсутствуют.');
        return;
    }

    const noteData = {
        name: document.getElementById('noteName').value,
        description: document.getElementById('noteDescription').value,
        importance: document.getElementById('notePriority').value,
    };

    try {
        const response = await fetch(`http://localhost:3003/api/patient-cards/notes/create/${patientCardId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                Authorization: `Bearer ${token}`,
            },
            body: JSON.stringify(noteData),
        });

        if (!response.ok) {
            const error = await response.json();
            throw new Error(error.message || 'Ошибка создания примечания');
        }

        alert('Примечание успешно добавлено!');
        document.getElementById('noteForm').reset();
        await loadNotes();
    } catch (error) {
        console.error('Ошибка сохранения примечания:', error);
        alert(`Не удалось сохранить примечание: ${error.message}`);
    }
});

// Ждем загрузки DOM, затем вызываем проверку ролей и скрытие элементов
document.addEventListener('DOMContentLoaded', () => {
    checkRoleAndHideElements();
    loadNotes();
});

</script>

</body>
</html>
