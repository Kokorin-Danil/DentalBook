<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style.css">
    <title>Медицинская карта пациента</title>
</head>
<body>

<div class="container-fluid">
  <div class="row">
    <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
      <div class="position-sticky pt-3">
        <a href="#" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
          <i class="fas fa-hospital fa-lg"></i>
          <span class="fs-4">Медицинская карта</span>
        </a>
        <hr>
        <ul class="nav flex-column">
          <li class="nav-item">
            <a href="medicalhistory.php" class="nav-link active" data-bs-toggle="collapse" data-bs-target="#history-collapse" aria-expanded="true" aria-controls="history-collapse">
              <i class="fas fa-file-medical"></i> История болезни
            </a>
          </li>
          <li class="nav-item">
            <a href="visits.php" class="nav-link" data-bs-toggle="collapse" data-bs-target="#visits-collapse" aria-expanded="false" aria-controls="visits-collapse">
              <i class="fas fa-calendar-check"></i> История посещений
            </a>
          </li>
          <li class="nav-item">
            <a href="diagnosis.php" class="nav-link" data-bs-toggle="collapse" data-bs-target="#diagnoses-collapse" aria-expanded="false" aria-controls="diagnoses-collapse">
              <i class="fas fa-stethoscope"></i> Диагнозы
            </a>
          </li>
          <li class="nav-item">
            <a href="treatment.php" class="nav-link" data-bs-toggle="collapse" data-bs-target="#treatment-collapse" aria-expanded="false" aria-controls="treatment-collapse">
              <i class="fas fa-syringe"></i> Лечение
            </a>
          </li>
          <li class="nav-item">
            <a href="analyses.php" class="nav-link" data-bs-toggle="collapse" data-bs-target="#analyses-collapse" aria-expanded="false" aria-controls="analyses-collapse">
              <i class="fas fa-flask"></i> Анализы
            </a>
          </li>
          <li class="nav-item">
            <a href="notes.php" class="nav-link" data-bs-toggle="collapse" data-bs-target="#doctorNotes-collapse" aria-expanded="false" aria-controls="doctorNotes-collapse">
              <i class="fas fa-sticky-note"></i> Заметки врача
            </a>
          </li>
        </ul>
      </div>
    </nav>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Медицинская карта пациента</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
            <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
          </div>
          <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
            <span data-feather="calendar"></span>
            This week
          </button>
        </div>
      </div>

      <!-- Форма поиска -->
      <form action="" method="GET" id="searchForm">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Введите ФИО или номер телефона пациента" name="search" required>
          <button class="btn btn-outline-secondary" type="submit">Поиск</button>
        </div>
      </form>

      <!-- Результаты поиска -->
      <div id="searchResults">
        <!-- Здесь будут отображаться результаты поиска -->
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
          <p>Контакты: info@dentalbook.com | +7 (123) 456-78-90</p>
          <p>&copy; 2024 Медицинская карта пациента</p>
        </div>
      </footer>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>
