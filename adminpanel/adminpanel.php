<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>  <!-- Подключаем Chart.js -->
    <title>Админ-панель</title>
</head>
<body>

<div class="container-fluid">
  <div class="row">
    <nav id="sidebar" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
      <div class="position-sticky pt-3">
        <a href="#" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
          <i class="fas fa-hospital fa-lg"></i>
          <span class="fs-4">Админ-панель</span>
        </a>
        <hr>
        <ul class="nav flex-column">
          <li class="nav-item">
            <a href="myclinic.php" class="nav-link active" data-bs-toggle="collapse" data-bs-target="#clinic-collapse" aria-expanded="true" aria-controls="clinic-collapse">
              <i class="fas fa-building"></i> Моя клиника
            </a>
          </li>
          <li class="nav-item">
            <a href="positions.php" class="nav-link" data-bs-toggle="collapse" data-bs-target="#positions-collapse" aria-expanded="false" aria-controls="positions-collapse">
              <i class="fas fa-briefcase"></i> Должности
            </a>
          </li>
          <li class="nav-item">
          <a href="worker.php" class="nav-link" data-bs-toggle="collapse" data-bs-target="#employees-collapse" aria-expanded="false" aria-controls="employees-collapse">
              <i class="fas fa-users"></i> Сотрудники
            </a>
          </li>
          <li class="nav-item">
            <a href="access.php" class="nav-link">
              <i class="fas fa-lock"></i> Права доступа
            </a>
          </li>
          <li class="nav-item">
            <a href="analysis.php" class="nav-link">
              <i class="fas fa-lock"></i> Аналитика и отчетность
            </a>
          </li>
          </ul>
      </div>
    </nav>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Моя клиника</h1>
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

      <div class="container">
          <h2>График доходов</h2>
          <canvas id="myChart"></canvas>

          <script>
            const ctx = document.getElementById('myChart').getContext('2d');
            const myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн', 'Июль', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек'],
                    datasets: [{
                        label: 'Доход',
                        data: [12000, 15000, 18000, 16000, 20000, 22000, 25000, 23000, 21000, 19000, 17000, 20000],
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
          </script>

          <!-- ... (ваш существующий код с информацией о клинике) ... -->
      </div>
    </main>
  </div>
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
        <p>&copy; 2024 DentalBook</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>

