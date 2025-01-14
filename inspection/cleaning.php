<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Профилактическая чистка</title>
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
        .card-body {
            padding: 15px;
        }
        h1 {
            color: #007bff;
            font-size: 24px;
            margin-bottom: 20px;
        }
        label {
            font-weight: 600;
        }
        button.btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        button.btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }
    </style>
</head>
<body>
<?php include '../users/navbar.php'; ?>
<div class="container mt-4">
    <h1 class="text-center">Профилактическая чистка</h1>

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

    <!-- Выбор пациента -->
    <div class="card mb-4">
        <div class="card-header">
            <i class="bi bi-person"></i> Выбор пациента
        </div>
        <div class="card-body">
            <select class="form-select" id="patientSelect">
                <option value="">Выберите пациента</option>
                <!-- Данные пациентов будут добавлены динамически -->
            </select>
        </div>
    </div>

    <!-- Цель чистки -->
    <div class="card">
        <div class="card-header">
            <i class="bi bi-journal-check"></i> Цель чистки
        </div>
        <div class="card-body">
            <textarea class="form-control" id="cleaningGoal" rows="4" placeholder="Опишите цель профилактической чистки"></textarea>
        </div>
    </div>

    <!-- Процедура чистки -->
    <div class="card">
        <div class="card-header">
            <i class="bi bi-tools"></i> Процедура чистки
        </div>
        <div class="card-body">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="scaling">
                <label class="form-check-label" for="scaling">Скалинг</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="polishing">
                <label class="form-check-label" for="polishing">Полировка зубов</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="fluorideTreatment">
                <label class="form-check-label" for="fluorideTreatment">Фторирование зубов</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="laserCleaning">
                <label class="form-check-label" for="laserCleaning">Лазерная чистка</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="airFlow">
                <label class="form-check-label" for="airFlow">Пескоструйная обработка</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="manualCleaning">
                <label class="form-check-label" for="manualCleaning">Ручная чистка</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="ultrasoundCleaning">
                <label class="form-check-label" for="ultrasoundCleaning">Ультразвуковая чистка</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="deepCleaning">
                <label class="form-check-label" for="deepCleaning">Глубокая чистка</label>
            </div>
            <textarea class="form-control mt-3" id="additionalCleaningProcedures" rows="4" placeholder="Укажите дополнительные процедуры"></textarea>
        </div>
    </div>

    <!-- Рекомендации после чистки -->
    <div class="card">
        <div class="card-header">
            <i class="bi bi-card-list"></i> Рекомендации после чистки
        </div>
        <div class="card-body">
            <textarea class="form-control" id="postCleaningCondition" rows="4" placeholder="Укажите рекомендации для пациента после чистки"></textarea>
        </div>
    </div>

    <!-- Кнопка -->
    <div class="d-flex justify-content-center">
        <button class="btn btn-primary" id="saveDataButton">
            <i class="bi bi-save"></i> Сохранить данные
        </button>
    </div>
</div>

<script>
    // Получение токена из cookies
    function getCookie(name) {
        const value = `; ${document.cookie}`;
        const parts = value.split(`; ${name}=`);
        if (parts.length === 2) return parts.pop().split(';').shift();
    }

    // Загрузка списка пациентов
    async function loadPatients() {
        const token = getCookie('token');
        try {
            const response = await fetch('http://localhost:3003/api/patient-cards/get/all', {
                headers: { 'Authorization': `Bearer ${token}` }
            });
            const patients = await response.json();
            const patientSelect = document.getElementById('patientSelect');

            patients.forEach(patient => {
                const option = document.createElement('option');
                option.value = patient.id;
                option.textContent = patient.fullName;
                patientSelect.appendChild(option);
            });
        } catch (error) {
            console.error('Ошибка при загрузке списка пациентов:', error);
        }
    }

    // Обработка выбора типа процедуры
    document.getElementById('procedureType').addEventListener('change', function () {
        const selectedValue = this.value;
        switch (selectedValue) {
            case 'primary':
                window.location.href = '/inspection/initial.php';
                break;
            case 'repeat':
                window.location.href = '/inspection/repeatvisit.php';
                break;
            case 'cleaning':
                window.location.href = '/inspection/cleaning.php';
                break;
            case 'emergency':
                window.location.href = '/inspection/danger.php';
                break;
        }
    });

    // Сохранение данных
    document.getElementById('saveDataButton').addEventListener('click', async () => {
        const token = getCookie('token');
        const patientId = document.getElementById('patientSelect').value;
        const cleaningGoal = document.getElementById('cleaningGoal').value;
        const additionalCleaningProcedures = document.getElementById('additionalCleaningProcedures').value;
        const postCleaningCondition = document.getElementById('postCleaningCondition').value;

        // Сбор выбранных процедур
        const cleaningProcedures = Array.from(document.querySelectorAll('.form-check-input:checked')).map(input =>
            input.nextElementSibling.textContent
        );

        if (!patientId || !cleaningGoal || cleaningProcedures.length === 0 || !postCleaningCondition) {
            alert('Заполните все поля!');
            return;
        }

        const data = {
            type: "Профилактическая чистка",
            cleaningGoal,
            cleaningProcedure: cleaningProcedures.join(', '),
            additionalCleaningProcedures,
            postCleaningCondition
        };

        try {
            const response = await fetch(`http://localhost:3003/api/patient-cards/examinationsheet/create/${patientId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                },
                body: JSON.stringify(data)
            });

            if (response.ok) {
                alert('Данные успешно сохранены!');
                document.getElementById('cleaningGoal').value = '';
                document.getElementById('additionalCleaningProcedures').value = '';
                document.getElementById('postCleaningCondition').value = '';
                document.querySelectorAll('.form-check-input').forEach(input => (input.checked = false));
                document.getElementById('patientSelect').value = '';
            } else {
                alert('Ошибка при сохранении данных!');
            }
        } catch (error) {
            console.error('Ошибка при сохранении данных:', error);
        }
    });

    document.addEventListener('DOMContentLoaded', loadPatients);
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
