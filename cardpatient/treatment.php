<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style.css">
    <title>Лечения</title>
</head>
<body>

<main class="container mt-4">
    <h2 class="mb-4">План лечения</h2>
    
    <!-- Форма поиска -->
    <form action="#" method="get" class="mb-4">
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Поиск по названию процедуры" name="search">
            <button class="btn btn-outline-secondary" type="submit">Поиск</button>
        </div>
    </form>

    <h2 class="mb-4 mt-5">Назначенные процедуры</h2>

        <!-- Таблица запланированных процедур -->
        <table class="table table-striped">
        <thead>
            <tr>
                <th>Название процедуры</th>
                <th>Дата планируемого проведения</th>
                <th>Статус</th>
                <th>Стоимость</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Протокол электроконвульсивной терапии</td>
                <td>2023-11-25</td>
                <td>Запланирована</td>
                <td>10 000 руб.</td>
                <td>
                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editScheduledProcedureModal">Редактировать</button>
                    <button class="btn btn-sm btn-danger">Удалить</button>
                </td>
            </tr>
            <!-- Добавьте больше строк по мере необходимости -->
        </tbody>
    </table>
    <!-- Модальное окно для добавления назначенных процедур -->
    <div class="modal fade" id="addScheduledProcedureModal" tabindex="-1" aria-labelledby="addScheduledProcedureModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addScheduledProcedureModalLabel">Добавление назначенной процедуры</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="#" method="post" class="mt-4">
                    <div class="modal-body">
                        <div class="row mb-2">
                            <label for="procedure_name_add" class="col-sm-2 col-form-label">Название процедуры:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="procedure_name_add" required>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="procedure_date_add" class="col-sm-2 col-form-label">Дата проведения:</label>
                            <div class="col-sm-10">
                                <input type="date" class="form-control" id="procedure_date_add" required>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="procedure_status_add" class="col-sm-2 col-form-label">Статус:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="procedure_status_add" required>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="procedure_cost_add" class="col-sm-2 col-form-label">Стоимость:</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" id="procedure_cost_add" min="1" max="365000" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отменить</button>
                        <button type="submit" class="btn btn-primary">Добавить процедуру</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
        <!-- Модальное окно для редактирования назначенной процедуры -->
        <div id="editScheduledProcedureModal" class="modal fade" tabindex="-1" aria-labelledby="editScheduledProcedureModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editScheduledProcedureModalLabel">Редактирование назначенной процедуры</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="#" method="post" class="mt-4">
                    <input type="hidden" name="procedureId" value="1">
                    <div class="modal-body">
                        <div class="row mb-2">
                            <label for="procedure_name_edit" class="col-sm-2 col-form-label">Название процедуры:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="procedure_name_edit" required>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="procedure_date_edit" class="col-sm-2 col-form-label">Дата проведения:</label>
                            <div class="col-sm-10">
                                <input type="date" class="form-control" id="procedure_date_edit" required>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="procedure_status_edit" class="col-sm-2 col-form-label">Статус:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="procedure_status_edit" required>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="procedure_cost_edit" class="col-sm-2 col-form-label">Стоимость:</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" id="procedure_cost_edit" min="1" max="365000" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отменить</button>
                        <button type="submit" class="btn btn-primary">Сохранить изменения</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Кнопка для открытия модального окна -->
    <button type="button" class="btn btn-primary mt-3 mb-4" data-bs-toggle="modal" data-bs-target="#addScheduledProcedureModal">Добавить назначенную процедуру</button>

    <h2 class="mb-4 mt-5">Назначенные препараты</h2>
        <!-- Таблица назначенных препаратов -->
        <table class="table table-striped mt-4">
        <thead>
            <tr>
                <th>Название препарата</th>
                <th>Дозировка</th>
                <th>Режим приема</th>
                <th>Продолжительность курса</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Левомицетин</td>
                <td>500 мг 3 раза в день</td>
                <td>Каждые 8 часов</td>
                <td>7 дней</td>
                <td>
                    <button class="btn btn-sm btn-primary">Редактировать</button>
                    <button class="btn btn-sm btn-danger">Удалить</button>
                </td>
            </tr>
            <!-- Добавьте больше строк по мере необходимости -->
        </tbody>
    </table>
    
    <!-- Модальное окно для добавления назначенных препаратов -->
    <div id="addAssignedMedicationModal" class="modal fade" tabindex="-1" aria-labelledby="addAssignedMedicationModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAssignedMedicationModalLabel">Добавление назначенного препарата</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/api/add-assigned-medication" method="post">
                    <input type="hidden" name="medicationId">
                    <div class="modal-body">
                        <div class="row mb-2">
                            <label for="medication_name_add" class="col-sm-2 col-form-label">Название препарата:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="medication_name_add" required>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="dosage_add" class="col-sm-2 col-form-label">Дозировка:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="dosage_add" required>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="regimen_add" class="col-sm-2 col-form-label">Режим приема:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="regimen_add" required>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="course_duration_add" class="col-sm-2 col-form-label">Продолжительность курса:</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" id="course_duration_add" min="1" max="365" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отменить</button>
                        <button type="submit" class="btn btn-primary">Добавить препарат</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Кнопка для открытия модального окна добавления препарата -->
    <button type="button" class="btn btn-primary mt-3 mb-4" data-bs-toggle="modal" data-bs-target="#addAssignedMedicationModal">Добавить назначенный препарат</button>

    <h2 class="mb-4 mt-5">Проведенное лечение</h2>
    <!-- Таблица проведенных процедур -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Название процедуры</th>
                <th>Дата проведения</th>
                <th>Результат</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Протокол электроконвульсивной терапии</td>
                <td>2023-11-20</td>
                <td>Улучшение симптомов</td>
                <td>
                    <button class="btn btn-sm btn-primary">Редактировать</button>
                    <button class="btn btn-sm btn-danger">Удалить</button>
                </td>
            </tr>
            <!-- Добавьте больше строк по мере необходимости -->
        </tbody>
    </table>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="script crossorigin="anonymous"></script>
</body>
</html>
