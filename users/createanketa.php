<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Анкета пациента</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 30px;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header h2 {
            margin: 0;
        }
        .close-button {
            font-size: 1.5rem;
            background: none;
            border: none;
            color: #6c757d;
            cursor: pointer;
            transition: color 0.3s ease;
        }
        .close-button:hover {
            color: #000;
        }
        .question-group {
            margin-bottom: 20px;
        }
        .question-group label {
            font-weight: 500;
        }
        .options {
            display: flex;
            gap: 15px;
            align-items: center;
        }
        .save-button {
            text-align: right;
        }
    </style>
</head>
<body>
<?php include '../adminpanel/navbar.php'; ?>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h2>Анкета</h2>
            <button class="close-button" onclick="window.location.href='/users/patients.php';">&times;</button>
        </div>

        <!-- Выбор пациента -->
        <label for="patientSelect"><strong>Выберите пациента:</strong></label>
        <select id="patientSelect" class="form-select mb-3"></select>

        <!-- Анкета -->
        <form id="surveyForm">
            <div class="question-group">
                <label>1. Испытывали ли вы боль или дискомфорт в зубах или деснах?</label>
                <div class="options">
                    <input type="radio" name="toothPain" value="Да"> Да
                    <input type="radio" name="toothPain" value="Нет"> Нет
                    <input type="radio" name="toothPain" value="Не знаю" checked> Не знаю
                </div>
            </div>
            <div class="question-group">
                <label>2. Есть ли повышенная чувствительность зубов к горячему, холодному или сладкому?</label>
                <div class="options">
                    <input type="radio" name="toothSensitivity" value="Да"> Да
                    <input type="radio" name="toothSensitivity" value="Нет"> Нет
                    <input type="radio" name="toothSensitivity" value="Не знаю" checked> Не знаю
                </div>
            </div>
            <div class="question-group">
                <label>3. Замечали ли вы кровоточивость десен при чистке зубов?</label>
                <div class="options">
                    <input type="radio" name="gumBleeding" value="Да"> Да
                    <input type="radio" name="gumBleeding" value="Нет"> Нет
                    <input type="radio" name="gumBleeding" value="Не знаю" checked> Не знаю
                </div>
            </div>
            <div class="question-group">
                <label>4. Устанавливали ли вам коронки, импланты или пломбы?</label>
                <div class="options">
                    <input type="radio" name="dentalWork" value="Да"> Да
                    <input type="radio" name="dentalWork" value="Нет"> Нет
                    <input type="radio" name="dentalWork" value="Не знаю" checked> Не знаю
                </div>
            </div>
            <div class="question-group">
                <label>5. Носите ли вы съемные протезы или брекеты?</label>
                <div class="options">
                    <input type="radio" name="dentalDevices" value="Да"> Да
                    <input type="radio" name="dentalDevices" value="Нет"> Нет
                    <input type="radio" name="dentalDevices" value="Не знаю" checked> Не знаю
                </div>
            </div>
            <div class="question-group">
                <label>6. Диагностировали ли вам воспаление десен (гингивит) или пародонтит?</label>
                <div class="options">
                    <input type="radio" name="gumInflammation" value="Да"> Да
                    <input type="radio" name="gumInflammation" value="Нет"> Нет
                    <input type="radio" name="gumInflammation" value="Не знаю" checked> Не знаю
                </div>
            </div>
            <div class="question-group">
                <label>7. Есть ли изменения в форме или цвете десен?</label>
                <div class="options">
                    <input type="radio" name="gumChanges" value="Да"> Да
                    <input type="radio" name="gumChanges" value="Нет"> Нет
                    <input type="radio" name="gumChanges" value="Не знаю" checked> Не знаю
                </div>
            </div>
            <div class="question-group">
                <label>8. Оголялись ли корни зубов?</label>
                <div class="options">
                    <input type="radio" name="exposedRoots" value="Да"> Да
                    <input type="radio" name="exposedRoots" value="Нет"> Нет
                    <input type="radio" name="exposedRoots" value="Не знаю" checked> Не знаю
                </div>
            </div>
            <div class="question-group">
                <label>9. Замечаете ли вы боль или щелчки в челюсти?</label>
                <div class="options">
                    <input type="radio" name="jawPain" value="Да"> Да
                    <input type="radio" name="jawPain" value="Нет"> Нет
                    <input type="radio" name="jawPain" value="Не знаю" checked> Не знаю
                </div>
            </div>
            <div class="question-group">
                <label>10. Сжимаете ли зубы или скрипите ими во сне?</label>
                <div class="options">
                    <input type="radio" name="teethGrinding" value="Да"> Да
                    <input type="radio" name="teethGrinding" value="Нет"> Нет
                    <input type="radio" name="teethGrinding" value="Не знаю" checked> Не знаю
                </div>
            </div>
            <div class="question-group">
                <label>11. Чистите ли вы зубы дважды в день?</label>
                <div class="options">
                    <input type="radio" name="brushesTeethTwice" value="Да"> Да
                    <input type="radio" name="brushesTeethTwice" value="Нет"> Нет
                    <input type="radio" name="brushesTeethTwice" value="Не знаю" checked> Не знаю
                </div>
            </div>
            <div class="question-group">
                <label>12. Используете ли зубную нить или ирригатор?</label>
                <div class="options">
                    <input type="radio" name="flossOrIrrigator" value="Да"> Да
                    <input type="radio" name="flossOrIrrigator" value="Нет"> Нет
                    <input type="radio" name="flossOrIrrigator" value="Не знаю" checked> Не знаю
                </div>
            </div>
            <div class="question-group">
                <label>13. Курите ли вы?</label>
                <div class="options">
                    <input type="radio" name="smoking" value="Да"> Да
                    <input type="radio" name="smoking" value="Нет"> Нет
                    <input type="radio" name="smoking" value="Не знаю" checked> Не знаю
                </div>
            </div>
            <div class="question-group">
                <label>14. Есть ли у вас аллергия на стоматологические материалы (например, пломбы)?</label>
                <div class="options">
                    <input type="radio" name="dentalAllergy" value="Да"> Да
                    <input type="radio" name="dentalAllergy" value="Нет"> Нет
                    <input type="radio" name="dentalAllergy" value="Не знаю" checked> Не знаю
                </div>
            </div>
            <div class="question-group">
                <label>15. Были ли у вас побочные реакции на анестетики?</label>
                <div class="options">
                    <input type="radio" name="anesthesiaReaction" value="Да"> Да
                    <input type="radio" name="anesthesiaReaction" value="Нет"> Нет
                    <input type="radio" name="anesthesiaReaction" value="Не знаю" checked> Не знаю
                </div>
            </div>
            <div class="save-button">
                <button type="submit" class="btn btn-primary">Сохранить</button>
            </div>
        </form>
    </div>
    <script>
        // Загрузка списка пациентов
        async function fetchPatients() {
            const token = getCookie('token');
            try {
                const response = await fetch('http://localhost:3003/api/patient-cards/get/all', {
                    headers: { Authorization: `Bearer ${token}` }
                });
                if (!response.ok) throw new Error('Ошибка загрузки списка пациентов');
                const patients = await response.json();
                document.getElementById('patientSelect').innerHTML = patients.map(patient =>
                    `<option value="${patient.id}">${patient.fullName}</option>`).join('');
            } catch (error) {
                console.error(error);
                alert('Ошибка при получении списка пациентов');
            }
        }

        // Функция получения токена
        function getCookie(name) {
            const value = `; ${document.cookie}`;
            const parts = value.split(`; ${name}=`);
            if (parts.length === 2) return parts.pop().split(';').shift();
        }

        // Сохранение анкеты
        document.getElementById('surveyForm').addEventListener('submit', async function(event) {
            event.preventDefault();
            const patientCardId = document.getElementById('patientSelect').value;
            const formData = new FormData(this);
            const requestBody = { patientCardId };

            formData.forEach((value, key) => { requestBody[key] = value; });

            try {
                const response = await fetch('http://localhost:3003/api/patient-cards/survey', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(requestBody)
                });

                if (!response.ok) throw new Error('Ошибка при сохранении анкеты');
                alert('Анкета успешно сохранена');
            } catch (error) {
                console.error(error);
                alert('Ошибка при сохранении анкеты');
            }
        });

        document.addEventListener('DOMContentLoaded', fetchPatients);
    </script>
</body>
</html>
