<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style.css">
    <title>Анализы пациентов | Стоматология</title>
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h3>Анализы пациентов</h3>
                <div class="d-flex justify-content-between">
                    <div class="d-flex justify-content-start">
                        <button class="btn btn-primary btn-sm me-2" data-bs-toggle="modal" data-bs-target="#addAnalysisModal"><span class="fas fa-plus-circle"></span> Добавить анализ</button>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button class="btn btn-success btn-sm" onclick="location.href='/save_changes';"><span class="fas fa-save"></span> Сохранить изменения</button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <!-- Таблица с данными анализов -->
                <table id="analysisTable" class="table table-striped">
                    <thead>
                        <tr>
                            <th>ФИО пациента</th>
                            <th>Дата анализа</th>
                            <th>Тип анализа</th>
                            <th>Снимок рентгена</th>
                            <th>Результаты</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody id="analysisListBody">
                        <!-- Здесь будут отображаться данные о пациентах -->
                        <tr>
                            <td>Иван Иванов</td>
                            <td>12.09.2024</td>
                            <td>Общий анализ крови</td>
                            <td><img src="#" alt="Снимок рентгена" width="100px" height="100px"></td>
                            <td>Е1:0</td>
                            <td><a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editAnalysisModal">Изменить</a> <a href="#" class="btn btn-sm btn-danger">Удалить</a></td>
                        </tr>
                    </tbody>
                </table>

                <!-- Модальное окно для добавления анализа -->
                <div class="modal fade" id="addAnalysisModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Добавление анализа</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="/save_analysis" method="POST">
                                    <div class="mb-3">
                                        <label for="patientName" class="form-label">ФИО пациента:</label>
                                        <input type="text" class="form-control" id="patientName" name="patientName" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="analysisDate" class="form-label">Дата анализа:</label>
                                        <input type="date" class="form-control" id="analysisDate" name="analysisDate" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="analysisType" class="form-label">Тип анализа:</label>
                                        <select class="form-select" id="analysisType" name="analysisType" required>
                                            <option value="">Выберите тип анализа</option>
                                            <option value="общий анализ крови">Общий анализ крови</option>
                                            <option value="биохимический анализ">Биохимический анализ</option>
                                            <!-- Добавьте другие типы анализов -->
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="xrayImage" class="form-label">Ссылка на снимок:</label>
                                        <input type="url" class="form-control" id="xrayImage" name="xrayImage" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="results" class="form-label">Результаты:</label>
                                        <textarea class="form-control" id="results" name="results" rows="3"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Сохранить анализ</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Модальное окно для редактирования анализа -->
                <div class="modal fade" id="editAnalysisModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Редактирование анализа</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="/save_analysis" method="POST">
                                    <input type="hidden" name="id" id="editAnalysisId">
                                    <div class="mb-3">
                                        <label for="patientNameEdit" class="form-label">ФИО пациента:</label>
                                        <input type="text" class="form-control" id="patientNameEdit" name="patientName" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="analysisDateEdit" class="form-label">Дата анализа:</label>
                                        <input type="date" class="form-control" id="analysisDateEdit" name="analysisDate" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="analysisTypeEdit" class="form-label">Тип анализа:</label>
                                        <select class="form-select" id="analysisTypeEdit" name="analysisType" required>
                                            <option value="">Выберите тип анализа</option>
                                            <option value="общий анализ крови">Общий анализ крови</option>
                                            <option value="биохимический анализ">Биохимический анализ</option>
                                            <!-- Добавьте другие типы анализов -->
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="xrayImageEdit" class="form-label">Ссылка на снимок:</label>
                                        <input type="url" class="form-control" id="xrayImageEdit" name="xrayImage" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="resultsEdit" class="form-label">Результаты:</label>
                                        <textarea class="form-control" id="resultsEdit" name="results" rows="3"></textarea>
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
    <script src="https://kit.fontawesome.com/your-fontawesome-kit.js" crossorigin="anonymous"></script>
</body>
</html>
