<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <title>Авторизация</title>
</head>
<body>
<div class="container">
    <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
        <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
            <span class="fs-4">DentalBook</span>
        </a>

        <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
            <li><a href="#" class="nav-link px-2">Главная</a></li>
            <li><a href="#" class="nav-link px-2">Вопросы</a></li>
            <li><a href="#" class="nav-link px-2">О нас</a></li>
            <li><a href="#" class="nav-link px-2">Контакты</a></li>
        </ul>
    </header>

    <main class="form-signin">
        <form id="authForm">
            <h1 class="h3 mb-3 fw-normal">Авторизация</h1>

            <div class="form-floating mb-3">
                <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" required>
                <label for="floatingInput">Логин</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="floatingPassword" placeholder="Password" required>
                <label for="floatingPassword">Пароль</label>
            </div>

            <div class="checkbox mb-3">
                <label>
                    <input type="checkbox" value="remember-me"> Запомнить меня
                </label>
            </div>
            <button class="w-100 btn btn-lg btn-primary" type="submit">Войти</button>
        </form>
    </main>

    <footer class="py-3 my-4">
        <ul class="nav justify-content-center border-bottom pb-3 mb-3">
            <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">Главная</a></li>
            <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">Функции</a></li>
            <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">Цены</a></li>
            <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">Вопросы</a></li>
            <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">О нас</a></li>
        </ul>
        <div class="text-center">
            <p>Контакты: info@dentalbook.com | +7 (123) 456-78-90</p>
            <p>&copy; 2024 DentalBook</p>
        </div>
    </footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
<script>
    document.querySelector('#authForm').addEventListener('submit', async (event) => {
        event.preventDefault(); // Предотвращаем отправку формы и перезагрузку страницы

        const email = document.getElementById('floatingInput').value.trim();
        const password = document.getElementById('floatingPassword').value.trim();

        if (!email || !password) {
            alert('Пожалуйста, заполните все поля.');
            return;
        }

        try {
            const response = await fetch('http://127.0.0.1:3001/api/users/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ email, password })
            });

            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.message || 'Не удалось авторизоваться');
            }

            const data = await response.json();
            alert(`Успешно авторизован! Ваш токен: ${data.token}`);
            
            // Сохраняем токен в localStorage для дальнейшего использования
            localStorage.setItem('token', data.token);

            // Перенаправление на другую страницу после успешной авторизации
            window.location.href = '/dashboard.html';
        } catch (error) {
            console.error('Ошибка запроса:', error);
            alert(`Ошибка: ${error.message || 'Произошла ошибка при подключении к серверу'}`);
        }
    });
</script>
</body>
</html>