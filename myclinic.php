<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style.css">  
    <title>Список клиник</title>
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h3>Список клиник</h3>
            </div>
            <div class="card-body">
                <!-- Таблица с данными клиник -->
                <table id="clinicTable" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Название</th>
                            <th>Адрес</th>
                            <th>Телефон</th>
                            <th>Email</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody id="clinicListBody">
                        <!-- Здесь будут отображаться данные о клиниках -->
                        <tr>
                            <td>Зубная клиника 'Смайлик'</td>
                            <td>ул. Ленина, д. 12, офис 202</td>
                            <td>+7 (495) 123-45-67</td>
                            <td>clinic@smailik-dent.ru</td>
                            <td>
                                <button class="btn btn-sm btn-primary" onclick="location.href='/edit_clinic?id=1';">Редактировать</button>
                                <button class="btn btn-sm btn-danger" onclick="location.href='/delete_clinic?id=1';">Удалить</button>
                            </td>
                        </tr>
                    </tbody>
                </table>                
                    <button type="submit" class="btn btn-primary">Добавить</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>
