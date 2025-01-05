<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>План лечения | DentalBook</title>
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

<div class="container mt-5">
    <div class="table-container">
        <form>
            <!-- Кнопка "Добавить" размещена вверху формы -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4>Планы лечения</h4>
                <button type="button" class="btn btn-success btn-add" data-bs-toggle="modal" data-bs-target="#addPlanModal">
                    <i class="fas fa-plus"></i> Добавить
                </button>
            </div>

            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Название</th>
                        <th scope="col">Комплексы</th>
                        <th scope="col">Автор</th>
                        <th scope="col">Создано</th>
                        <th scope="col">Статус</th>
                        <th scope="col">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>54692</td>
                        <td><a href="#">План лечения от 14.03.2023</a></td>
                        <td>Комплекс 1 [13, 11, 21, 12]</td>
                        <td>Путков Степан Сергеевич</td>
                        <td>14.03.2023</td>
                        <td class="text-success">Подтверждена</td>
                        <td>
                            <button class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></button>
                            <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td>54689</td>
                        <td><a href="#">67890</a></td>
                        <td>Комплекс 1 [13, 12, 11]</td>
                        <td>Путков Степан Сергеевич</td>
                        <td>14.03.2023</td>
                        <td class="text-secondary">Предварительный</td>
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

<!-- Модальное окно добавления плана лечения -->
<div class="modal fade" id="addPlanModal" tabindex="-1" aria-labelledby="addPlanModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPlanModalLabel">Добавить план лечения</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form>
                <div class="modal-body">
                    <!-- ФИО пациента -->
                    <div class="mb-3">
                        <label for="patientName" class="form-label">ФИО пациента</label>
                        <input type="text" class="form-control" id="patientName" placeholder="Введите ФИО пациента">
                    </div>

                    <!-- Название плана -->
                    <div class="mb-3">
                        <label for="planName" class="form-label">Название</label>
                        <input type="text" class="form-control" id="planName" placeholder="Введите название плана">
                    </div>

                    <!-- Комплексы -->
                    <div class="mb-3">
                        <label for="planComplex" class="form-label">Комплексы</label>
                        <input type="text" class="form-control" id="planComplex" placeholder="Введите комплексы">
                    </div>

                    <!-- Автор -->
                    <div class="mb-3">
                        <label for="planAuthor" class="form-label">Автор</label>
                        <input type="text" class="form-control" id="planAuthor" placeholder="Введите имя автора">
                    </div>

                    <!-- Статус -->
                    <div class="mb-3">
                        <label for="planStatus" class="form-label">Статус</label>
                        <select class="form-select" id="planStatus">
                            <option value="confirmed">Подтверждена</option>
                            <option value="preliminary">Предварительный</option>
                            <option value="active">Активен</option>
                            <option value="completed">Лечение завершено</option>
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
