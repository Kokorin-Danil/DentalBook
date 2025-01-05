<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style.css">
    <title>Список сотрудников</title>
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h3>Список сотрудников</h3>
            </div>
            <div class="card-body">
                <!-- Блок сортировки -->
                <div class="d-flex justify-content-end align-items-center mb-3">
                    <select id="sortSelect" class="form-select form-select-sm me-2">
                        <option value="name">Имя</option>
                        <option value="surname">Фамилия</option>
                        <option value="position">Должность</option>
                        <option value="birthdate">Дата рождения</option>
                        <option value="salary">Зарплата</option>
                    </select>
                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="sortTable()">Применить сортировку</button>
                </div>

                <!-- Таблица с данными сотрудников -->
                <table id="employeeTable" class="table table-striped">
                    <thead>
                        <tr>
                            <th>№</th>
                            <th>Имя</th>
                            <th>Фамилия</th>
                            <th>Должность</th>
                            <th>Дата рождения</th>
                            <th>Зарплата</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody id="employeeListBody">
                        <!-- Здесь будут отображаться данные о сотрудниках -->
                        <tr>
                            <td>1</td>
                            <td>Иван Иванович</td>
                            <td>Иванов Иван</td>
                            <td>Врач стоматолога</td>
                            <td>15.08.1990</td>
                            <td>150 000 руб.</td>
                            <td>
                                <button class="btn btn-sm btn-primary" onclick="location.href='/edit_employee?id=1';">Редактировать</button>
                                <button class="btn btn-sm btn-danger" onclick="location.href='/delete_employee?id=1';">Удалить</button>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Петр Петрович</td>
                            <td>Петров Петр</td>
                            <td>Стоматолог-пародонтолог</td>
                            <td>20.05.1988</td>
                            <td>120 000 руб.</td>
                            <td>
                                <button class="btn btn-sm btn-primary" onclick="location.href='/edit_employee?id=2';">Редактировать</button>
                                <button class="btn btn-sm btn-danger" onclick="location.href='/delete_employee?id=2';">Удалить</button>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- Форма добавления сотрудника -->
                <form action="/add_employee" method="post">                    
                    <button type="submit" class="btn btn-primary">Добавить</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>

