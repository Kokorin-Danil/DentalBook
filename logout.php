<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Выход из профиля | DentalBook</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Удаляем токен из cookies
            document.cookie = "token=; path=/; expires=Thu, 01 Jan 1970 00:00:00 UTC;";

            // Удаляем токен из localStorage (если используется)
            localStorage.removeItem("token");

            // Таймер для редиректа через 3 секунды
            setTimeout(() => {
                window.location.href = "index.php"; // Перенаправление на страницу входа
            }, 3000);
        });
    </script>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
        }
        .logout-container {
            text-align: center;
            background: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .spinner-border {
            width: 3rem;
            height: 3rem;
        }
    </style>
</head>
<body>
    <div class="logout-container">
        <h2>Выход из профиля...</h2>
        <p>Вы будете перенаправлены на страницу входа через несколько секунд.</p>
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Загрузка...</span>
        </div>
    </div>
</body>
</html>
