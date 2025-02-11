<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Просмотр анкеты</title>
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
        .answer {
            font-style: italic;
        }
        #noSurveyMessage {
            color: #dc3545;
            font-size: 1.2rem;
            text-align: center;
            padding: 20px;
            border: 1px solid #dc3545;
            border-radius: 10px;
            background-color: #ffe6e6;
            margin-top: 20px;
            display: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h2>Просмотр анкеты</h2>
            <button class="close-button" onclick="window.location.href='/users/patients.php';">&times;</button>
        </div>

        <!-- Survey Content -->
        <div id="surveyContent">
            <div class="question-group">
                <label>1. Испытывали ли вы боль или дискомфорт в зубах или деснах?</label>
                <p class="answer" id="toothPain">Загрузка...</p>
            </div>
            <div class="question-group">
                <label>2. Есть ли повышенная чувствительность зубов к горячему, холодному или сладкому?</label>
                <p class="answer" id="toothSensitivity">Загрузка...</p>
            </div>
            <div class="question-group">
                <label>3. Замечали ли вы кровоточивость десен при чистке зубов?</label>
                <p class="answer" id="gumBleeding">Загрузка...</p>
            </div>
            <div class="question-group">
                <label>4. Устанавливали ли вам коронки, импланты или пломбы?</label>
                <p class="answer" id="dentalWork">Загрузка...</p>
            </div>
            <div class="question-group">
                <label>5. Носите ли вы съемные протезы или брекеты?</label>
                <p class="answer" id="dentalDevices">Загрузка...</p>
            </div>
            <div class="question-group">
                <label>6. Диагностировали ли вам воспаление десен (гингивит) или пародонтит?</label>
                <p class="answer" id="gumInflammation">Загрузка...</p>
            </div>
            <div class="question-group">
                <label>7. Есть ли изменения в форме или цвете десен?</label>
                <p class="answer" id="gumChanges">Загрузка...</p>
            </div>
            <div class="question-group">
                <label>8. Оголялись ли корни зубов?</label>
                <p class="answer" id="exposedRoots">Загрузка...</p>
            </div>
            <div class="question-group">
                <label>9. Замечаете ли вы боль или щелчки в челюсти?</label>
                <p class="answer" id="jawPain">Загрузка...</p>
            </div>
            <div class="question-group">
                <label>10. Сжимаете ли зубы или скрипите ими во сне?</label>
                <p class="answer" id="teethGrinding">Загрузка...</p>
            </div>
            <div class="question-group">
                <label>11. Чистите ли вы зубы дважды в день?</label>
                <p class="answer" id="brushesTeethTwice">Загрузка...</p>
            </div>
            <div class="question-group">
                <label>12. Используете ли зубную нить или ирригатор?</label>
                <p class="answer" id="flossOrIrrigator">Загрузка...</p>
            </div>
            <div class="question-group">
                <label>13. Курите ли вы?</label>
                <p class="answer" id="smoking">Загрузка...</p>
            </div>
            <div class="question-group">
                <label>14. Есть ли у вас аллергия на стоматологические материалы (например, пломбы)?</label>
                <p class="answer" id="dentalAllergy">Загрузка...</p>
            </div>
            <div class="question-group">
                <label>15. Были ли у вас побочные реакции на анестетики?</label>
                <p class="answer" id="anesthesiaReaction">Загрузка...</p>
            </div>
        </div>

        <!-- No Survey Message -->
        <div id="noSurveyMessage">Анкета еще не заполнена</div>
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

        if (!['admin', 'doctor', 'client'].includes(userRole)) {
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
    async function fetchSurvey(patientCardId) {
        try {
            const response = await fetch(`http://localhost:3003/api/patient-cards/survey/${patientCardId}`);
            if (!response.ok) throw new Error();

            const survey = await response.json();
            if (!survey || Object.keys(survey).length === 0) {
                throw new Error();
            }

            let isSurveyFilled = false;
            for (const [key, value] of Object.entries(survey)) {
                const element = document.getElementById(key);
                if (element) {
                    element.textContent = value || 'Не указано';
                    if (value) isSurveyFilled = true; // Если есть хотя бы один ответ, анкета заполнена
                }
            }

            if (isSurveyFilled) {
                document.getElementById('surveyContent').style.display = 'block';
                document.getElementById('noSurveyMessage').style.display = 'none';
            } else {
                throw new Error(); // Если нет значимых данных, считаем анкету незаполненной
            }
        } catch {
            document.getElementById('surveyContent').style.display = 'none';
            document.getElementById('noSurveyMessage').style.display = 'block';
        }
    }

    // Проверка роли пользователя
    function getCookie(name) {
        const value = `; ${document.cookie}`;
        const parts = value.split(`; ${name}=`);
        if (parts.length === 2) return parts.pop().split(';').shift();
    }

    function getRoleFromToken() {
        const token = getCookie('token');
        if (token) {
            try {
                const payload = JSON.parse(atob(token.split('.')[1]));
                return payload.role;
            } catch (error) {
                console.error('Ошибка декодирования токена:', error);
                return null;
            }
        }
        return null;
    }

    document.addEventListener('DOMContentLoaded', () => {
        const urlParams = new URLSearchParams(window.location.search);
        const patientCardId = urlParams.get('patientCardId');
        const userRole = getRoleFromToken();

        // Изменяем поведение кнопки закрытия для клиента
        const closeButton = document.querySelector('.close-button');
        if (userRole === 'client') {
            closeButton.addEventListener('click', () => {
                history.back(); // Возвращаем на предыдущую страницу
            });
        } else {
            closeButton.addEventListener('click', () => {
                window.location.href = '/users/patients.php'; // Перенаправление для других ролей
            });
        }

        if (patientCardId) {
            fetchSurvey(patientCardId);
        }
    });
</script>

</body>
</html>
