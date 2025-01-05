<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style.css">
    <title>Заметки врача</title>
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h3>Заметки врача</h3>
                <div class="d-flex justify-content-between">
                    <div class="d-flex justify-content-start">
                        <button class="btn btn-primary btn-sm me-2" data-bs-toggle="modal" data-bs-target="#addNoteModal"><span class="fas fa-plus-circle"></span> Добавить заметку</button>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-success btn-sm" onclick="location.href='/save_changes';"><span class="fas fa-save"></span> Сохранить изменения</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <!-- Таблица с данными заметок -->
                <table id="notesTable" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Дата</th>
                            <th>ФИО пациента</th>
                            <th>Заметка</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody id="notesListBody">
                        <!-- Здесь будут отображаться данные о заметках -->
                        <tr>
                            <td>12.09.2024</td>
                            <td>Иван Иванов</td>
                            <td>Принял лекарство и назначил физиотерапию</td>
                            <td><a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editNoteModal">Изменить</a> <a href="#" class="btn btn-sm btn-danger">Удалить</a></td>
                        </tr>
                    </tbody>
                </table>

                <!-- Модальное окно для добавления заметки -->
                <div class="modal fade" id="addNoteModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Добавление заметки</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="/save_note" method="POST">
                                    <div class="mb-3">
                                        <label for="date" class="form-label">Дата:</label>
                                        <input type="date" class="form-control" id="date" name="date" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="patientFIO" class="form-label">ФИО пациента:</label>
                                        <input type="text" class="form-control" id="patientFIO" name="patientFIO" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="note" class="form-label">Заметка:</label>
                                        <textarea class="form-control" id="note" name="note" rows="3"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Сохранить заметку</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Модальное окно для редактирования заметки -->
                <div class="modal fade" id="editNoteModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Редактирование заметки</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="/save_note" method="POST">
                                    <input type="hidden" name="id" id="editNoteId">
                                    <div class="mb-3">
                                        <label for="dateEdit" class="form-label">Дата:</label>
                                        <input type="date" class="form-control" id="dateEdit" name="date" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="patientFIOEdit" class="form-label">ФИО пациента:</label>
                                        <input type="text" class="form-control" id="patientFIOEdit" name="patientFIO" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="noteEdit" class="form-label">Заметка:</label>
                                        <textarea class="form-control" id="noteEdit" name="note" rows="3"></textarea>
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
