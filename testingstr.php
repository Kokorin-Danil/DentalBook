<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Профиль пациента | DentalBook</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        #content {
            margin: 20px;
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
<div id="content">
    <div class="table-container">
        <!-- Кнопка добавления -->
        <button class="btn btn-primary btn-add mb-3" data-bs-toggle="modal" data-bs-target="#addVisitModal">Добавить визит</button>

        <!-- Таблица визитов -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Визит</th>
                    <th>Тип</th>
                    <th>Статус</th>
                    <th>Зубы</th>
                    <th>Цена</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>2094208</td>
                    <td>11.06.2021, 15:20</td>
                    <td>Лечение</td>
                    <td>Не подтвержден</td>
                    <td>-</td>
                    <td>-</td>
                    <td>
                        <button class="btn btn-sm btn-info"><i class="fas fa-eye"></i></button>
                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editVisitModal"><i class="fas fa-edit"></i></button>
                        <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- Модальное окно редактирования визита -->
<div class="modal fade" id="editVisitModal" tabindex="-1" aria-labelledby="editVisitModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editVisitModalLabel">Редактировать визит</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
            </div>
            <div class="modal-body">
                <form>
                    <!-- Описание -->
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingDescription">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDescription" aria-expanded="true" aria-controls="collapseDescription">
                                Описание
                            </button>
                        </h2>
                        <div id="collapseDescription" class="accordion-collapse collapse show" aria-labelledby="headingDescription">
                            <div class="accordion-body">
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="visitDate" class="form-label">Дата визита</label>
                                        <input type="date" id="visitDate" class="form-control" value="2021-06-11">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="visitTime" class="form-label">Время визита</label>
                                        <input type="time" id="visitTime" class="form-control" value="10:00">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="visitDuration" class="form-label">Длительность визита (в мин)</label>
                                        <input type="number" id="visitDuration" class="form-control" value="30">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="doctor" class="form-label">Лечащий врач</label>
                                        <select id="doctor" class="form-select">
                                            <option selected>Иванов Иванович Иван</option>
                                            <option>Петров Петрович Петр</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="assistant" class="form-label">Ассистент</label>
                                        <select id="assistant" class="form-select">
                                            <option selected>-</option>
                                            <option>Сидоров Сидорович Сидор</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="plannedProcedures" class="form-label">Планируемые процедуры</label>
                                        <input type="text" id="plannedProcedures" class="form-control" value="Первичная консультация">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="status" class="form-label">Статус</label>
                                        <select id="status" class="form-select">
                                            <option selected>Подтверждена</option>
                                            <option>Не подтверждена</option>
                                            <option>Отменена</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="treatmentTemplate" class="form-label">Шаблон лечения</label>
                                        <select id="treatmentTemplate" class="form-select">
                                            <option selected>-</option>
                                            <option>Шаблон 1</option>
                                            <option>Шаблон 2</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="treatmentPlan" class="form-label">План лечения</label>
                                        <select id="treatmentPlan" class="form-select">
                                            <option selected>-</option>
                                            <option>План 1</option>
                                            <option>План 2</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="complaints" class="form-label">Жалобы</label>
                                    <textarea id="complaints" class="form-control" rows="3">Жалоб нет</textarea>
                                </div>
                            </div>
                        </div>
                    </div>


                        <!-- Зубная карта -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTeeth">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTeeth" aria-expanded="false" aria-controls="collapseTeeth">
                                    Зубная карта
                                </button>
                            </h2>
                            <div id="collapseTeeth" class="accordion-collapse collapse" aria-labelledby="headingTeeth">
                                <div class="accordion-body">
                                    <div class="teeth-chart">
                                        <p>Зубная карта отображается здесь.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Диагноз -->
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingDiagnosis">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDiagnosis" aria-expanded="false" aria-controls="collapseDiagnosis">
                                    Диагноз
                                </button>
                            </h2>
                            <div id="collapseDiagnosis" class="accordion-collapse collapse" aria-labelledby="headingDiagnosis">
                                <div class="accordion-body">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Диагноз</th>
                                                <th>Код МКБ</th>
                                                <th>Зубы</th>
                                                <th>Действия</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Кариес глубокий острый</td>
                                                <td>K02.1</td>
                                                <td>15, 13</td>
                                                <td>
                                                    <button class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></button>
                                                    <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="mt-3">
                                        <label for="addDiagnosis" class="form-label">Добавить диагноз</label>
                                        <input type="text" id="addDiagnosis" class="form-control" placeholder="Введите диагноз">
                                        <button class="btn btn-primary mt-2">Добавить</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                <button type="button" class="btn btn-primary">Сохранить</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
