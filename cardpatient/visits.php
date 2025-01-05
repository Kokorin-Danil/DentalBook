<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style.css">
    <title>History of Visits</title>
</head>
<body>

<main class="container mt-4">
    <h2 class="mb-4">История посещений</h2>

    <!-- Form for adding new visit -->
    <form action="#" method="post" class="mb-4">
        <div class="row mb-2">
            <label for="visitDate" class="col-sm-2 col-form-label">Дата и время визита:</label>
            <div class="col-sm-10">
                <input type="datetime-local" class="form-control" id="visitDate" required>
            </div>
        </div>
        <div class="row mb-2">
            <label for="visitType" class="col-sm-2 col-form-label">Тип визита:</label>
            <div class="col-sm-10">
                <select class="form-select" id="visitType" required>
                    <option value="">Выберите тип визита</option>
                    <option value="planned">Плановый осмотр</option>
                    <option value="treatment">Лечение</option>
                    <option value="hygiene">Профессиональная гигиена</option>
                    <option value="emergency">Срочный визит</option>
                </select>
            </div>
        </div>
        <div class="row mb-2">
            <label for="doctorName" class="col-sm-2 col-form-label">Врач:</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="doctorName" placeholder="ФИО врача" required>
            </div>
        </div>
        <div class="row mb-2">
            <label for="visitDescription" class="col-sm-2 col-form-label">Краткое описание:</label>
            <div class="col-sm-10">
                <textarea class="form-control" id="visitDescription" rows="3"></textarea>
            </div>
        </div>
        <div class="row mb-2">
            <label for="cost" class="col-sm-2 col-form-label">Стоимость:</label>
            <div class="col-sm-4">
                <input type="number" class="form-control" id="cost" step="0.01" required>
            </div>
            <label for="paymentStatus" class="col-sm-2 col-form-label">Статус оплаты:</label>
            <div class="col-sm-4">
                <select class="form-select" id="paymentStatus" required>
                    <option value="">Выберите статус</option>
                    <option value="paid">Оплачен</option>
                    <option value="pending">В процессе оплаты</option>
                    <option value="unpaid">Не оплачен</option>
                </select>
            </div>
        </div>
        <div class="row justify-content-end">
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Добавить визит</button>
            </div>
        </div>
    </form>

    <!-- Search form -->
    <form action="#" method="get" class="mb-4">
        <input type="text" class="form-control me-2" placeholder="Поиск по истории посещений" id="searchInput">
        <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
    </form>

    <!-- Table for displaying visits history -->
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Дата и время</th>
                <th>Тип визита</th>
                <th>Врач</th>
                <th>Краткое описание</th>
                <th>Стоимость</th>
                <th>Статус оплаты</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>2023-01-15 14:00:00</td>
                <td>Плановый осмотр</td>
                <td>Иванова А.С.</td>
                <td>Оценка состояния зубов</td>
                <td>1500.00</td>
                <td>Оплачен</td>
            </tr>
            <!-- Добавьте больше строк по мере необходимости -->
        </tbody>
    </table>

</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>
