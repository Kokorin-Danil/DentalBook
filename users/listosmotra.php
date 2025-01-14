<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Лист осмотра</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            max-width: 900px;
            background: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }
        .card {
            border: 1px solid #ddd;
            margin-bottom: 20px;
            border-radius: 10px;
        }
        .card-header {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border-radius: 10px 10px 0 0;
            font-weight: bold;
        }
        h1 {
            color: #007bff;
            font-size: 24px;
            margin-bottom: 20px;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }
        #procedureType {
            max-width: 300px;
            margin-bottom: 15px;
        }
        .info-text {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <?php include '../users/navbar.php'; ?>
    <div class="container">
        <h1 class="text-center">Лист осмотра</h1>

        <!-- Выбор типа процедуры -->
        <div class="card mb-4">
            <div class="card-header">
                <i class="bi bi-list-task"></i> Выбор типа процедуры
            </div>
            <div class="card-body">
                <select class="form-select" id="procedureType">
                    <option value="">Выберите тип процедуры</option>
                    <option value="primary">Первичный осмотр</option>
                    <option value="repeat">Повторный визит</option>
                    <option value="cleaning">Профилактическая чистка</option>
                    <option value="emergency">Экстренный случай</option>
                </select>
            </div>
        </div>

        <!-- Информация об осмотре -->
        <div class="card">
            <div class="card-header">
                <i class="bi bi-journal-medical"></i> Детали осмотра
            </div>
            <div class="card-body">
                <p class="info-text" id="inspectionDate"><strong>Дата осмотра:</strong> 12.01.2025</p>
                <p class="info-text" id="inspectionDetailsContent">
                    <strong>Жалобы пациента:</strong> Боль в зубе
                </p>
                <p class="info-text"><strong>Предварительный диагноз:</strong> Кариес</p>
                <p><strong>Рекомендации врача:</strong> Начать лечение кариеса</p>
            </div>
        </div>

        <!-- Кнопка для возврата -->
        <div class="d-flex justify-content-center">
            <a href="/users/patientlist.php" class="btn btn-primary">
                <i class="bi bi-arrow-left"></i> Вернуться к списку пациентов
            </a>
        </div>
    </div>

    <script>
        // Смена типа процедуры и обновление контента
        document.getElementById('procedureType').addEventListener('change', function () {
            const selectedProcedure = this.value;
            const inspectionDetailsContent = document.getElementById('inspectionDetailsContent');

            switch (selectedProcedure) {
                case 'primary':
                    inspectionDetailsContent.innerHTML = `
                        <strong>Жалобы пациента:</strong> Боль в зубе<br>
                        <strong>Предварительный диагноз:</strong> Кариес<br>
                        <strong>Рекомендации врача:</strong> Начать лечение кариеса
                    `;
                    break;
                case 'repeat':
                    inspectionDetailsContent.innerHTML = `
                        <strong>Динамика состояния:</strong> Состояние улучшилось<br>
                        <strong>Результаты лечения:</strong> Удаление кариеса завершено
                    `;
                    break;
                case 'cleaning':
                    inspectionDetailsContent.innerHTML = `
                        <strong>Цель чистки:</strong> Устранение налета<br>
                        <strong>Процедура чистки:</strong> Скалинг<br>
                        <strong>Состояние после чистки:</strong> Зубы стали чистыми
                    `;
                    break;
                case 'emergency':
                    inspectionDetailsContent.innerHTML = `
                        <strong>Описание проблемы:</strong> Сильная боль в зубе<br>
                        <strong>Оценка состояния:</strong> Сильная зубная боль<br>
                        <strong>Принятые меры:</strong> Временное обезболивание<br>
                        <strong>Рекомендации врача:</strong> Обратиться за лечением кариеса
                    `;
                    break;
                default:
                    inspectionDetailsContent.innerHTML = `
                        Выберите тип процедуры для отображения информации.
                    `;
                    break;
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
