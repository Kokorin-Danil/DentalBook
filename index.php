<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DentalBook</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <header class="py-3 mb-4 border-bottom">
            <div class="d-flex flex-wrap align-items-center justify-content-between">
                <a href="/" class="d-flex align-items-center mb-2 mb-md-0 me-md-auto text-decoration-none">
                    <span class="fs-4">DentalBook</span>
                </a>
                <nav class="nav col-12 col-md-auto mb-2 mb-md-0">
                    <ul class="nav nav-pills">
                        <li class="nav-item"><a href="#" class="nav-link px-2">Главная</a></li>
                        <li class="nav-item"><a href="createcardpatient.php" class="nav-link px-2">Создание карты пациента</a></li>
                        <li class="nav-item"><a href="cardpatient/cardpatient.php" class="nav-link px-2">Карта пациента</a></li>
                        <li class="nav-item"><a href="inspection.php" class="nav-link px-2">Лист осмотра</a></li>
                        <li class="nav-item"><a href="analyses.php" class="nav-link px-2">Анализы</a></li>
                        <li class="nav-item"><a href="adminpanel/adminpanel.php" class="nav-link px-2">Админ-панель</a></li>
                        <li class="nav-item"><a href="#" class="nav-link px-2">О нас</a></li>
                        <li class="nav-item"><a href="#" class="nav-link px-2">Контакты</a></li>
                    </ul> 
                </nav>
                <a href="auth.php" class="btn btn-primary mb-2 mb-md-0">Авторизация</a>
                <a href="profile/profileadmin.php" class="btn btn-primary mb-2 mb-md-0">Профиль админа</a>
                <a href="profile/profiledantist.php" class="btn btn-primary mb-2 mb-md-0">Профиль дантиста</a>
                <a href="profile/profilepatient.php" class="btn btn-primary mb-2 mb-md-0">Профиль пациента</a>
            </div>
        </header>

        <main>
            <section class="hero-section py-5">
                <div class="container">
                    <h1>Электронная стоматология</h1>
                    <p>DentalBook — улучшает качество стоматологических услуг для всех. Для врачей система обеспечивает быстрый доступ к информации о пациентах, что позволяет проводить более точную диагностику и назначать эффективное лечение. Пациенты получают удобный сервис, оперативную обратную связь и персональный подход к лечению.</p>
                    <a href="login.php" class="btn btn-primary">Перейти к карте</a>
                </div>
            </section>

            <section class="news-section py-5">
                <div class="container">
                    <h2 class="text-center mb-4">Новости стоматологии</h2>
                    <div class="row">
                      <!--  Здесь будут карточки новостей -->
                      <div class="col-md-6 col-lg-3 mb-4">
                        <div class="card">
                            <img src="placeholder.jpg" class="card-img-top" alt="Заголовок новости">
                            <div class="card-body">
                                <h5 class="card-title">Заголовок новости</h5>
                                <p class="card-text">Краткое описание новости.</p>
                            </div>
                        </div>
                      </div>
                      <!-- Добавьте ещё карточки -->
                    </div>
                </div>
            </section>
            <?php include('maps.php'); ?>
        </main>
    </div>
    <footer class="py-3 my-4">
    <ul class="nav justify-content-center border-bottom pb-3 mb-3">
        <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">Главная</a></li>
        <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">Функции</a></li>
        <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">Цены</a></li>
        <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">Вопросы</a></li>
        <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">О нас</a></li>
    </ul>
    <div class="text-center">
        <p>Контакты: info@dentalbook.com</a> | +7 (123) 456-78-90</a></p>
        <p>&copy; 2024 DentalBook</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>
