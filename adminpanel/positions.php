<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style.css">  
    <title>Должности</title>
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h3>Список должностей</h3>
            </div>
            <div class="card-body">
                <!-- Таблица с данными должностей -->
                <table id="positionTable" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Название</th>
                            <th>Описание</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody id="positionListBody">
                        <!-- Здесь будут отображаться данные о должностях -->
                        <tr>
                            <td>Врач стоматолога</td>
                            <td>Лечение зубов и полости рта</td>
                            <td>
                                <button class="btn btn-sm btn-primary" onclick="location.href='/edit_position?id=1';">Редактировать</button>
                                <button class="btn btn-sm btn-danger" onclick="location.href='/delete_position?id=1';">Удалить</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Стоматолог-пародонтолог</td>
                            <td>Лечение пародонта и десен</td>
                            <td>
                                <button class="btn btn-sm btn-primary" onclick="location.href='/edit_position?id=2';">Редактировать</button>
                                <button class="btn btn-sm btn-danger" onclick="location.href='/delete_position?id=2';">Удалить</button>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- Форма добавления должности -->
                <form action="/add_position" method="post">    
                    <button type="submit" class="btn btn-primary">Добавить</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>
