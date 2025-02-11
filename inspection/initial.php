<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Первичный осмотр</title>
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
<?php include '../adminpanel/navbar.php'; ?>
<div class="container mt-4">
    <h1 class="text-center">Первичный осмотр</h1>

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

    <!-- Жалобы пациента -->
    <div class="card">
        <div class="card-header">
            <i class="bi bi-chat-dots"></i> Жалобы пациента
        </div>
        <div class="card-body">
            <textarea class="form-control" rows="4" id="complaints" placeholder="Опишите жалобы пациента"></textarea>
        </div>
    </div>

       <!-- Предварительный диагноз -->
       <div class="card">
        <div class="card-header">
            <i class="bi bi-clipboard-check"></i> Предварительный диагноз
        </div>
        <div class="card-body">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="diagnosisCaries">
                <label class="form-check-label" for="diagnosisCaries">Кариес</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="diagnosisPeriodontitis">
                <label class="form-check-label" for="diagnosisPeriodontitis">Пародонтит</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="diagnosisGingivitis">
                <label class="form-check-label" for="diagnosisGingivitis">Гингивит</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="diagnosisAbscess">
                <label class="form-check-label" for="diagnosisAbscess">Абсцесс</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="diagnosisHypersensitivity">
                <label class="form-check-label" for="diagnosisHypersensitivity">Гиперчувствительность зубов</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="diagnosisTMJDysfunction">
                <label class="form-check-label" for="diagnosisTMJDysfunction">Дисфункция ВНЧС</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="diagnosisCandida">
                <label class="form-check-label" for="diagnosisCandida">Кандидоз</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="diagnosisLeukoplakia">
                <label class="form-check-label" for="diagnosisLeukoplakia">Лейкоплакия</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="diagnosisWisdomTeeth">
                <label class="form-check-label" for="diagnosisWisdomTeeth">Ретинированные зубы мудрости</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="diagnosisEnamelHypoplasia">
                <label class="form-check-label" for="diagnosisEnamelHypoplasia">Гипоплазия эмали</label>
            </div>
        </div>
    </div>

    <!-- Рекомендации врача -->
    <div class="card">
        <div class="card-header">
            <i class="bi bi-card-list"></i> Рекомендации врача
        </div>
        <div class="card-body">
            <textarea class="form-control" rows="4" id="doctorRecommendations" placeholder="Укажите рекомендации для пациента"></textarea>
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
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            });
            const patients = await response.json();
            const patientSelect = document.getElementById('patientSelect');

            patients.forEach(patient => {
                const option = document.createElement('option');
                option.value = patient.id; // ID пациента
                option.textContent = patient.fullName; // ФИО пациента
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
        const complaints = document.getElementById('complaints').value;
        const doctorRecommendations = document.getElementById('doctorRecommendations').value;

        // Сбор выбранных диагнозов
        const diagnoses = [];
        document.querySelectorAll('.form-check-input:checked').forEach(checkbox => {
            diagnoses.push(checkbox.nextElementSibling.textContent);
        });

        // Проверка на заполненность данных
        if (!patientId || !complaints || diagnoses.length === 0 || !doctorRecommendations) {
            alert('Пожалуйста, заполните все поля!');
            return;
        }

        const data = {
            type: "Первичный осмотр",
            complaints: complaints,
            preliminaryDiagnosis: diagnoses.join(', '),
            doctorRecommendations: doctorRecommendations
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
                document.getElementById('complaints').value = '';
                document.getElementById('doctorRecommendations').value = '';
                document.querySelectorAll('.form-check-input').forEach(checkbox => checkbox.checked = false);
                document.getElementById('patientSelect').value = '';
            } else {
                alert('Ошибка при сохранении данных!');
            }
        } catch (error) {
            console.error('Ошибка при отправке данных:', error);
        }
    });

    // Загрузка списка пациентов при загрузке страницы
    document.addEventListener('DOMContentLoaded', loadPatients);
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
