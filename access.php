<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Права доступа | DentalBook</title>
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h3>Права доступа</h3>
                <div class="d-flex justify-content-between">
                    <div class="d-flex justify-content-start">
                        <button class="btn btn-primary btn-sm me-2" data-bs-toggle="modal" data-bs-target="#addUserModal"><span class="fas fa-plus-circle"></span> Добавить пользователя</button>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-success btn-sm" onclick="location.href='/save_changes';"><span class="fas fa-save"></span> Сохранить</button>
                    </div>
                </div>
            <div class="card-body">
                <!-- Таблица с данными пользователей -->
                <table id="userTable" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Имя</th>
                            <th><i class="fas fa-user"></i> Роль</th>
                            <th>Разрешения</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody id="userListBody">
                        <!-- Здесь будут отображаться данные пользователей -->
                        <tr>
                            <td>Иван Иванов</td>
                            <td>Администратор</td>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="viewUsers1" checked>
                                    <label class="form-check-label" for="viewUsers1">Просмотр пользователей</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="editUsers1" checked>
                                    <label class="form-check-label" for="editUsers1">Редактирование пользователей</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="viewProfiles1" checked>
                                    <label class="form-check-label" for="viewProfiles1">Просмотр профилей</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="editProfiles1" checked>
                                    <label class="form-check-label" for="editProfiles1">Редактирование профилей</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="viewAppointments1" checked>
                                    <label class="form-check-label" for="viewAppointments1">Просмотр назначений</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="editAppointments1" checked>
                                    <label class="form-check-label" for="editAppointments1">Редактирование назначений</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="viewReports1" checked>
                                    <label class="form-check-label" for="viewReports1">Просмотр отчетов</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="editReports1" checked>
                                    <label class="form-check-label" for="editReports1">Редактирование отчетов</label>
                                </div>
                            </td>
                            <td>
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editUserModal"><span class="fas fa-edit"></span> Редактировать</button>
                                <button class="btn btn-danger btn-sm" onclick="location.href='/delete_user?id=1';"><span class="fas fa-trash-alt"></span> Удалить</button>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- Модальное окно для добавления пользователя -->
                <div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Добавление пользователя</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="/save_user" method="POST">
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Имя:</label>
                                        <input type="text" class="form-control" id="username" name="username" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="role" class="form-label">Роль:</label>
                                        <select class="form-select" id="role" name="role" required>
                                            <option value="">Выберите роль</option>
                                            <option value="admin">Администратор</option>
                                            <option value="moderator">Врач</option>
                                            <option value="user">Пользователь</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="permissions" class="form-label">Разрешения:</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="viewUsers" name="permissions" value="viewUsers">
                                            <label class="form-check-label" for="viewUsers">Просмотр пользователей</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="editUsers" name="permissions" value="editUsers">
                                            <label class="form-check-label" for="editUsers">Редактирование пользователей</label>
                                        </div>
                                        <!-- Добавьте другие разрешения -->
                                    </div>
                                    <button type="submit" class="btn btn-primary">Сохранить</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Модальное окно для редактирования пользователя -->
                <div class="modal fade" id="editUserModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Редактирование пользователя</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="/save_user" method="POST">
                                    <input type="hidden" name="id" id="editUserId">
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Имя:</label>
                                        <input type="text" class="form-control" id="editUsername" name="username" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="role" class="form-label">Роль:</label>
                                        <select class="form-select" id="editRole" name="role" required>
                                            <option value="">Выберите роль</option>
                                            <option value="admin">Администратор</option>
                                            <option value="moderator">Модератор</option>
                                            <option value="user">Пользователь</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="permissions" class="form-label">Разрешения:</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="editViewUsers" name="permissions" value="viewUsers">
                                            <label class="form-check-label" for="editViewUsers">Просмотр пользователей</label>
                                        </div>
                                        <!-- Добавьте другие разрешения -->
                                    </div>
                                    <button type="submit" class="btn btn-primary">Сохранить изменения</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="script crossorigin="anonymous"></script>
</body>
</html>

