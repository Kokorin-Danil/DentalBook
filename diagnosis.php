<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style.css">
    <title>Диагнозы</title>
</head>
<body>

<main class="container mt-4">
    <h2 class="mb-4">Список диагнозов</h2>

    <!-- Форма поиска и фильтров -->
    <form action="#" method="get" class="mb-4">
        <div class="row mb-2">
            <div class="col-md-6">
                <input type="text" class="form-control" placeholder="Поиск по названию диагноза или коду МКБ" name="search">
            </div>
            <div class="col-md-3">
                <select class="form-select" name="status_filter">
                    <option value="">Все статусы</option>
                    <option value="активен">Активен</option>
                    <option value="излечен">Излечен</option>
                    <option value="в ремиссии">В ремиссии</option>
                </select>
            </div>
            <div class="col-md-3">
                <input type="date" class="form-control" name="date_filter">
            </div>
        </div>

        <!-- Кнопки сортировки -->
        <div class="row justify-content-end">
            <div class="col-auto">
                <button type="submit" class="btn btn-primary me-1">Применить фильтры</button>
                <a href="#" class="btn btn-secondary">Сбросить фильтры</a>
            </div>
        </div>
    </form>

    <!-- Таблица диагнозов -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Код МКБ</th>
                <th>Название диагноза</th>
                <th>Дата постановки</th>
                <th>Врач</th>
                <th>Статус</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            <!-- Здесь будут отображаться данные о диагнозах -->
            <tr>
                <td>M10:0</td>
                <td>Гипертония</td>
                <td>2023-01-15</td>
                <td>Иванова А.С.</td>
                <td>Активен</td>
                <td>
                    <button class="btn btn-sm btn-primary">Редактировать</button>
                    <button class="btn btn-sm btn-danger">Удалить</button>
                </td>
            </tr>
            <!-- Добавьте больше строк по мере необходимости -->
        </tbody>
    </table>

    <!-- Форма добавления нового диагноза -->
    <form action="#" method="post" class="mt-4">
        <div class="row mb-2">
            <label for="mkb_code" class="col-sm-2 col-form-label">Код МКБ:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="mkb_code" required>
            </div>
        </div>
        <div class="row mb-2">
            <label for="diagnosis_name" class="col-sm-2 col-form-label">Название диагноза:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="diagnosis_name" required>
            </div>
        </div>
        <div class="row mb-2">
            <label for="date_set" class="col-sm-2 col-form-label">Дата постановки:</label>
            <div class="col-sm-10">
                <input type="date" class="form-control" id="date_set" required>
            </div>
        </div>
        <div class="row mb-2">
            <label for="doctor_name" class="col-sm-2 col-form-label">Врач:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="doctor_name">
            </div>
        </div>
        <div class="row mb-2">
            <label for="status" class="col-sm-2 col-form-label">Статус:</label>
            <div class="col-sm-10">
                <select class="form-select" id="status">
                    <option value="">Выберите статус</option>
                    <option value="активен">Активен</option>
                    <option value="излечен">Излечен</option>
                    <option value="в ремиссии">В ремиссии</option>
                </select>
            </div>
        </div>
        <div class="row justify-content-end">
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Добавить диагноз</button>
            </div>
        </div>
    </form>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>
