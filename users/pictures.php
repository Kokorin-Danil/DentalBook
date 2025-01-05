<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Снимки пациента | DentalBook</title>
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
    <!-- Профиль пациента -->
    <?php include 'profile.php'; ?>

    <!-- Таблица снимков -->
    <div class="table-container mt-5">
        <form>
            <!-- Кнопка "Добавить" вверху формы -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4>Снимки пациента</h4>
                <button type="button" class="btn btn-success btn-add" data-bs-toggle="modal" data-bs-target="#addImageModal">
                    <i class="fas fa-plus"></i> Добавить
                </button>
            </div>

            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Дата загрузки</th>
                        <th scope="col">Снимок</th>
                        <th scope="col">Визит</th>
                        <th scope="col">Зубы</th>
                        <th scope="col">Описание</th>
                        <th scope="col">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>182778</td>
                        <td>15.12.2022</td>
                        <td><img src="img/image1.jpg" alt="Снимок 1" class="img-thumbnail" style="max-width: 100px;"></td>
                        <td>Визит 1</td>
                        <td>12, 13</td>
                        <td>Примечание к снимку</td>
                        <td>
                            <button class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>182779</td>
                        <td>16.12.2022</td>
                        <td><img src="img/image2.jpg" alt="Снимок 2" class="img-thumbnail" style="max-width: 100px;"></td>
                        <td>Визит 2</td>
                        <td>22, 23</td>
                        <td>Примечание к снимку</td>
                        <td>
                            <button class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>

    <!-- Модальное окно добавления снимка -->
    <div class="modal fade" id="addImageModal" tabindex="-1" aria-labelledby="addImageModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addImageModalLabel">Добавить снимок</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form>
                    <div class="modal-body">
                        <!-- ФИО пациента -->
                        <div class="mb-3">
                            <label for="patientName" class="form-label">ФИО пациента</label>
                            <input type="text" class="form-control" id="patientName" placeholder="Введите ФИО пациента">
                        </div>

                        <!-- Дата загрузки -->
                        <div class="mb-3">
                            <label for="uploadDate" class="form-label">Дата загрузки</label>
                            <input type="date" class="form-control" id="uploadDate">
                        </div>

                        <!-- Визит -->
                        <div class="mb-3">
                            <label for="visit" class="form-label">Визит</label>
                            <input type="text" class="form-control" id="visit" placeholder="Введите номер визита">
                        </div>

                        <!-- Зубы -->
                        <div class="mb-3">
                            <label for="teeth" class="form-label">Зубы</label>
                            <input type="text" class="form-control" id="teeth" placeholder="Введите номера зубов">
                        </div>

                        <!-- Описание -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Описание</label>
                            <textarea class="form-control" id="description" placeholder="Введите описание"></textarea>
                        </div>

                        <!-- Снимок -->
                        <div class="mb-3">
                            <label for="imageFile" class="form-label">Снимок</label>
                            <input type="file" class="form-control" id="imageFile">
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
