<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Создание листа осмотра стоматологической клиники</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .procedure-section {
            display: none;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Создание листа осмотра стоматологической клиники</h1>
    <!-- Форма поиска по ФИО пациента -->
    <div class="search-patient mb-4">
        <label for="searchPatient" class="form-label">Поиск пациента по ФИО:</label>
        <div class="input-group">
            <input type="text" class="form-control" id="searchPatient" placeholder="Введите ФИО пациента">
            <button class="btn btn-primary" type="button">
                <i class="bi bi-search"></i> Найти
            </button>
        </div>
    </div>

    <div class="mb-3">
        <label for="procedureType" class="form-label">Тип процедуры:</label>
        <select class="form-select" id="procedureType">
            <option value="">Выберите тип процедуры</option>
            <option value="primary-examination">Первичный осмотр</option>
            <option value="repeat-visit">Повторный визит</option>
            <option value="preventive-cleaning">Профилактическая чистка</option>
            <option value="emergency-case">Экстренный случай</option>
        </select>
    </div>

    <!-- Первичный осмотр -->
    <div id="primary-examination" class="procedure-section">
        <h1 class="mb-4">Первичный осмотр</h1>
        <div class="card mb-4">
            <div class="card-header">
                <h2>Жалобы пациента</h2>
            </div>
            <div class="card-body">
                <textarea class="form-control" rows="5" placeholder="Опишите жалобы пациента"></textarea>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header">
                <h2>Предварительный диагноз</h2>
            </div>
            <div class="card-body">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="diagnosisCaries">
                    <label class="form-check-label" for="diagnosisCaries">Кариес</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="diagnosisPeriodontitis">
                    <label class="form-check-label" for="diagnosisPeriodontitis">Пародонтит</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="diagnosisGingivitis">
                    <label class="form-check-label" for="diagnosisGingivitis">Гингивит</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="diagnosisAbscess">
                    <label class="form-check-label" for="diagnosisAbscess">Абсцесс</label>
                </div>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header">
                <h2>Состояние зубов</h2>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Номер зуба</th>
                            <th>Состояние</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <select class="form-select">
                                    <option value="">Выберите номер</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                </select>
                            </td>
                            <td>
                                <select class="form-select">
                                    <option value="">Выберите состояние</option>
                                    <option value="healthy">Здоровый</option>
                                    <option value="caries">Кариес</option>
                                    <option value="damaged">Поврежден</option>
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header">
                <h2>Рекомендации врача</h2>
            </div>
            <div class="card-body">
                <textarea class="form-control" rows="5" placeholder="Укажите рекомендации для пациента"></textarea>
            </div>
        </div>
        <div class="d-flex justify-content-between">
            <button class="btn btn-success">Сохранить данные</button>
            <a href="/" class="btn btn-secondary">Вернуться на главную</a>
        </div>
    </div>

<!-- Повторный визит -->
<div id="repeat-visit" class="procedure-section">
        <h1 class="mb-4">Повторный визит</h1>
        <div class="card mb-4">
            <div class="card-header">
                <h2>Динамика состояния</h2>
            </div>
            <div class="card-body">
                <textarea class="form-control" rows="5" placeholder="Опишите изменения в состоянии пациента с момента последнего визита"></textarea>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header">
                <h2>Состояние зубов</h2>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Номер зуба</th>
                            <th>Текущее состояние</th>
                            <th>Изменения</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <select class="form-select">
                                    <option value="">Выберите номер</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                </select>
                            </td>
                            <td>
                                <select class="form-select">
                                    <option value="">Выберите состояние</option>
                                    <option value="healthy">Здоровый</option>
                                    <option value="caries">Кариес</option>
                                    <option value="damaged">Поврежден</option>
                                </select>
                            </td>
                            <td>
                                <textarea class="form-control" rows="2" placeholder="Опишите изменения"></textarea>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header">
                <h2>Результаты лечения</h2>
            </div>
            <div class="card-body">
                <textarea class="form-control" rows="5" placeholder="Опишите результаты проведенного лечения"></textarea>
            </div>
        </div>
        <div class="d-flex justify-content-between">
            <button class="btn btn-success">Сохранить данные</button>
            <a href="/" class="btn btn-secondary">Вернуться на главную</a>
        </div>
    </div>

    <!-- Профилактическая чистка -->
    <div id="preventive-cleaning" class="procedure-section">
        <h1 class="mb-4">Профилактическая чистка</h1>

        <!-- Информация о пациенте -->
        <div class="card mb-4">
            <div class="card-header">
                <h2>Информация о пациенте</h2>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="patientName" class="form-label">ФИО пациента:</label>
                    <input type="text" class="form-control" id="patientName" placeholder="Введите ФИО пациента">
                </div>
                <div class="mb-3">
                    <label for="patientAge" class="form-label">Возраст пациента:</label>
                    <input type="number" class="form-control" id="patientAge" placeholder="Введите возраст пациента">
                </div>
            </div>
        </div>

        <!-- Цель чистки -->
        <div class="card mb-4">
            <div class="card-header">
                <h2>Цель чистки</h2>
            </div>
            <div class="card-body">
                <textarea class="form-control" rows="5" placeholder="Опишите цель профилактической чистки"></textarea>
            </div>
        </div>

        <!-- Состояние до чистки -->
        <div class="card mb-4">
            <div class="card-header">
                <h2>Состояние зубов до чистки</h2>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Номер зуба</th>
                            <th>Состояние</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <select class="form-select">
                                    <option value="">Выберите номер</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                </select>
                            </td>
                            <td>
                                <select class="form-select">
                                    <option value="">Выберите состояние</option>
                                    <option value="healthy">Здоровый</option>
                                    <option value="plaque">Налет</option>
                                    <option value="tartar">Камень</option>
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <button class="btn btn-primary mt-3">Добавить зуб</button>
            </div>
        </div>

        <!-- Процедура чистки -->
        <div class="card mb-4">
            <div class="card-header">
                <h2>Процедура чистки</h2>
            </div>
            <div class="card-body">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="scaling">
                    <label class="form-check-label" for="scaling">Скалинг</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="polishing">
                    <label class="form-check-label" for="polishing">Полировка зубов</label>
                </div>
                <textarea class="form-control mt-3" rows="4" placeholder="Дополнительные процедуры"></textarea>
            </div>
        </div>

        <!-- Состояние после чистки -->
        <div class="card mb-4">
            <div class="card-header">
                <h2>Состояние после чистки</h2>
            </div>
            <div class="card-body">
                <textarea class="form-control" rows="5" placeholder="Опишите состояние зубов"></textarea>
            </div>
        </div>
    </div>

    <!-- Экстренный случай -->
    <div id="emergency-case" class="procedure-section">
        <h1 class="mb-4">Экстренный случай</h1>
        <!-- Описание проблемы -->
        <div class="card mb-4">
            <div class="card-header">
                <h2>Описание проблемы</h2>
            </div>
            <div class="card-body">
                <textarea class="form-control" rows="5" placeholder="Опишите проблему"></textarea>
            </div>
        </div>
        <!-- Оценка состояния пациента -->
        <div class="card mb-4">
            <div class="card-header">
                <h2>Оценка состояния</h2>
            </div>
            <div class="card-body">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="severePain">
                    <label class="form-check-label" for="severePain">Сильная зубная боль</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="swelling">
                    <label class="form-check-label" for="swelling">Опухоль/воспаление</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="bleeding">
                    <label class="form-check-label" for="bleeding">Кровотечение</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="trauma">
                    <label class="form-check-label" for="trauma">Травма зуба/челюсти</label>
                </div>
                <textarea class="form-control mt-3" rows="4" placeholder="Дополнительные детали"></textarea>
            </div>
        </div>
        <!-- Принятые меры -->
        <div class="card mb-4">
            <div class="card-header">
                <h2>Принятые меры</h2>
            </div>
            <div class="card-body">
                <textarea class="form-control" rows="5" placeholder="Опишите предпринятые меры"></textarea>
            </div>
        </div>
        <!-- Рекомендации пациенту -->
        <div class="card mb-4">
            <div class="card-header">
                <h2>Рекомендации пациенту</h2>
            </div>
            <div class="card-body">
                <textarea class="form-control"
                rows="5" placeholder="Например, рекомендации по дальнейшим действиям"></textarea>
            </div>
        </div>
        <!-- Кнопки -->
        <div class="d-flex justify-content-between">
            <button class="btn btn-danger">Сохранить данные</button>
            <a href="/" class="btn btn-secondary">Вернуться на главную</a>
        </div>
    </div>
</div>

<script>
    // Обработчик изменения типа процедуры
    document.getElementById('procedureType').addEventListener('change', function () {
        // Скрыть все секции процедур
        document.querySelectorAll('.procedure-section').forEach(section => section.style.display = 'none');

        // Отобразить выбранную секцию
        const selectedSection = document.getElementById(this.value);
        if (selectedSection) selectedSection.style.display = 'block';
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

