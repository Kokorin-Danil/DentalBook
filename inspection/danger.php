<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Экстренный случай</title>
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
            background-color: #dc3545;
            color: white;
            padding: 10px 15px;
            border-radius: 10px 10px 0 0;
            font-weight: bold;
        }
        .card-body {
            padding: 15px;
        }
        h1 {
            color: #dc3545;
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
<?php include '../adminpanel/navbar.php'; ?>
<div class="main-content">
    <h1 class="text-center">Экстренный случай</h1>

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
                <option value="emergency" selected>Экстренный случай</option>
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

    <!-- Описание проблемы -->
    <div class="card">
        <div class="card-header">
            <i class="bi bi-exclamation-circle"></i> Описание проблемы
        </div>
        <div class="card-body">
            <textarea class="form-control" id="problemDescription" rows="4" placeholder="Опишите проблему пациента"></textarea>
        </div>
    </div>

    <!-- Оценка состояния пациента -->
    <div class="card">
        <div class="card-header">
            <i class="bi bi-shield-check"></i> Оценка состояния пациента
        </div>
        <div class="card-body">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="severePain">
                <label class="form-check-label" for="severePain">Сильная зубная боль</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="swelling">
                <label class="form-check-label" for="swelling">Опухоль/воспаление</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="bleeding">
                <label class="form-check-label" for="bleeding">Кровотечение</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="trauma">
                <label class="form-check-label" for="trauma">Травма зуба/челюсти</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="numbness">
                <label class="form-check-label" for="numbness">Онемение в области лица или челюсти</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="badBreath">
                <label class="form-check-label" for="badBreath">Резкий запах изо рта</label>
            </div>
        </div>
    </div>

    <!-- Принятые меры -->
    <div class="card">
        <div class="card-header">
            <i class="bi bi-wrench"></i> Принятые меры
        </div>
        <div class="card-body">
            <textarea class="form-control" id="measuresTaken" rows="4" placeholder="Опишите предпринятые меры"></textarea>
        </div>
    </div>

    <!-- Рекомендации пациенту -->
    <div class="card">
        <div class="card-header">
            <i class="bi bi-card-list"></i> Рекомендации пациенту
        </div>
        <div class="card-body">
            <textarea class="form-control" id="doctorRecommendations" rows="4" placeholder="Укажите рекомендации для пациента"></textarea>
        </div>
    </div>

    <!-- Кнопка -->
    <div class="d-flex justify-content-center">
        <button class="btn btn-primary" id="saveDataButton">
            <i class="bi bi-save"></i> Сохранить данные
        </button>
    </div>
</div>
<script type="module">
    import { getToken, parseJwt } from "/js/auth.js";

    function checkAccess() {
        const token = getToken();

        if (!token) {
            alert('Вы не авторизованы!');
            window.location.replace('/index.php');
            return;
        }

        const decodedToken = parseJwt(token);
        const userRole = decodedToken?.role;

        if (userRole !== 'doctor') {
            alert('У вас нет доступа к этой странице!');
            if (document.referrer) {
                window.location.href = document.referrer; // Возвращаем на предыдущую страницу
            } else {
                window.location.replace('/index.php'); // Если истории нет, направляем на auth.php
            }
        }
    }

    checkAccess();
</script>
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

    // Сохранение данных
    document.getElementById('saveDataButton').addEventListener('click', async () => {
        const token = getCookie('token');
        const patientId = document.getElementById('patientSelect').value;
        const problemDescription = document.getElementById('problemDescription').value;
        const measuresTaken = document.getElementById('measuresTaken').value;
        const doctorRecommendations = document.getElementById('doctorRecommendations').value;

        const conditionAssessments = Array.from(document.querySelectorAll('.form-check-input:checked')).map(input =>
            input.nextElementSibling.textContent
        );

        if (!patientId || !problemDescription || conditionAssessments.length === 0 || !measuresTaken || !doctorRecommendations) {
            alert('Заполните все поля!');
            return;
        }

        const data = {
            type: "Экстренный случай",
            problemDescription,
            conditionAssessment: conditionAssessments.join(', '),
            measuresTaken,
            doctorRecommendations
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
                document.getElementById('problemDescription').value = '';
                document.getElementById('measuresTaken').value = '';
                document.getElementById('doctorRecommendations').value = '';
                document.querySelectorAll('.form-check-input').forEach(input => (input.checked = false));
                document.getElementById('patientSelect').value = '';
            } else {
                alert('Ошибка при сохранении данных!');
            }
        } catch (error) {
            console.error('Ошибка при сохранении данных:', error);
        }
    });

    // Переключение типов процедур
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

    document.addEventListener('DOMContentLoaded', loadPatients);
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
