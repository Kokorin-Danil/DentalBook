<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Аналитика и отчетность</title>
</head>
<body>

<div class="container mt-4">
    <h1>Аналитика и отчетность</h1>

    <div class="row">
        <div class="col-md-6">
            <h2>Доход за последние 12 месяцев</h2>
            <canvas id="incomeChart"></canvas>
            <script>
              const ctxIncome = document.getElementById('incomeChart').getContext('2d');
              const incomeChart = new Chart(ctxIncome, {
                  type: 'bar',
                  data: {
                      labels: ['Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн', 'Июль', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек'],
                      datasets: [{
                          label: 'Доход (руб.)',
                          data: [120000, 150000, 180000, 160000, 200000, 220000, 250000, 230000, 210000, 190000, 170000, 200000],
                          backgroundColor: 'rgba(54, 162, 235, 0.8)',
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
        </div>
        <div class="col-md-6">
            <h2>Количество пациентов за последние 12 месяцев</h2>
            <canvas id="patientsChart"></canvas>
            <script>
              const ctxPatients = document.getElementById('patientsChart').getContext('2d');
              const patientsChart = new Chart(ctxPatients, {
                  type: 'line',
                  data: {
                      labels: ['Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн', 'Июль', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек'],
                      datasets: [{
                          label: 'Количество пациентов',
                          data: [150, 180, 200, 170, 220, 250, 280, 260, 240, 220, 200, 230],
                          backgroundColor: 'rgba(255, 99, 132, 0.2)',
                          borderColor: 'rgba(255, 99, 132, 1)',
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
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <h2>Распределение пациентов по возрасту</h2>
            <canvas id="ageDistributionChart"></canvas>
            <script>
              const ctxAge = document.getElementById('ageDistributionChart').getContext('2d');
              const ageChart = new Chart(ctxAge, {
                  type: 'bar',
                  data: {
                      labels: ['0-10', '11-20', '21-30', '31-40', '41-50', '51-60', '61-70', '71+'],
                      datasets: [{
                          label: 'Пациенты',
                          data: [100, 150, 200, 180, 220, 250, 280, 260],
                          backgroundColor: 'rgba(75, 192, 192, 0.8)',
                          borderColor: 'rgba(75, 192, 192, 1)',
                          borderWidth: 1
                      }]
                  },
                  options: {
                      scales: {
                          y: {
                              beginAtZero: true,
                              ticks: {
                                  callback: function(value) {
                                      return value + ' пациентов';
                                  }
                              }
                          },
                          x: {
                              grid: {
                                  drawOnChartArea: false
                              }
                          }
                      }
                  }
              });
            </script>
        </div>
        <div class="col-md-6">
            <h2>Распределение пациентов по полу</h2>
            <canvas id="genderDistributionChart"></canvas>
            <script>
              const ctxGender = document.getElementById('genderDistributionChart').getContext('2d');
              const genderChart = new Chart(ctxGender, {
                  type: 'pie',
                  data: {
                      labels: ['Женщины', 'Мужчины'],
                      datasets: [{
                          label: 'Пол',
                          data: [45, 55],
                          backgroundColor: [
                              'rgba(255, 99, 132, 0.8)',
                              'rgba(54, 162, 235, 0.8)'
                          ],
                          hoverBackgroundColor: [
                              'rgba(255, 99, 132, 1)',
                              'rgba(54, 162, 235, 1)'
                          ]
                      }]
                  },
                  options: {
                      responsive: true,
                      plugins: {
                          legend: {
                              position: 'top'
                          }
                      }
                  }
              });
            </script>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <h2>Выгрузка данных</h2>
            <p>Здесь вы можете выгрузить данные в различных форматах:</p>
            <a href="#" class="btn btn-primary">CSV</a>
            <a href="#" class="btn btn-primary">Excel</a>
            <a href="#" class="btn btn-primary">PDF</a>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>
