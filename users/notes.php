<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Примечания | DentalBook</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        #sidebar {
            width: 250px;
            background-color: #f8f9fa;
            padding: 20px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            overflow-y: auto;
            border-right: 1px solid #ddd;
            box-shadow: 2px 0 8px rgba(0, 0, 0, 0.05);
        }
        #sidebar h4 {
            font-weight: bold;
            color: #007bff;
            text-align: center;
            margin-bottom: 1.5rem;
        }
        body {
            background-color: #f4f6f9;
        }
        #content {
            margin-left: 270px;
            padding: 20px;
        }
        .table-container {
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }
        .btn-primary {
            background: linear-gradient(45deg, #007bff, #0056b3);
            border: none;
        }
        .btn-primary:hover {
            background: linear-gradient(45deg, #0056b3, #003f88);
        }
    </style>
</head>
<body>
    <?php include 'profile.php'; ?>
    <?php include 'navbar.php'; ?>
    <div class="container mt-5">
        <div class="table-container">
            <form>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4>Примечания</h4>
                    <button type="button" class="btn btn-success btn-add" data-bs-toggle="modal" data-bs-target="#addNoteModal">
                        <i class="fas fa-plus"></i> Добавить
                    </button>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Имя</th>
                            <th scope="col">Описание</th>
                            <th scope="col">Важность</th>
                            <th scope="col">Создан</th>
                            <th scope="col">Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Примечание 1</td>
                            <td>Пациенту следует соблюдать диету</td>
                            <td class="text-danger">Высокая</td>
                            <td>24.12.2024</td>
                            <td>
                                <button class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Примечание 2</td>
                            <td>Назначено повторное посещение</td>
                            <td class="text-secondary">Средняя</td>
                            <td>22.12.2024</td>
                            <td>
                                <button class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>
    </div>

    <div class="modal fade" id="addNoteModal" tabindex="-1" aria-labelledby="addNoteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addNoteModalLabel">Добавить примечание</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form>
                    <div class="modal-body">
                        <!-- ФИО пациента -->
                        <div class="mb-3">
                            <label for="patientName" class="form-label">ФИО пациента</label>
                            <input type="text" class="form-control" id="patientName" placeholder="Введите ФИО пациента">
                        </div>

                        <!-- Имя примечания -->
                        <div class="mb-3">
                            <label for="noteName" class="form-label">Имя</label>
                            <input type="text" class="form-control" id="noteName" placeholder="Введите имя примечания">
                        </div>

                        <!-- Описание примечания -->
                        <div class="mb-3">
                            <label for="noteDescription" class="form-label">Описание</label>
                            <textarea class="form-control" id="noteDescription" placeholder="Введите описание"></textarea>
                        </div>

                        <!-- Важность -->
                        <div class="mb-3">
                            <label for="notePriority" class="form-label">Важность</label>
                            <select class="form-select" id="notePriority">
                                <option value="high">Высокая</option>
                                <option value="medium">Средняя</option>
                                <option value="low">Низкая</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                        <button type="submit" class="btn btn-primary">Добавить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
