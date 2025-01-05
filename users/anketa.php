<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Анкета пациента</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
        }

        .container {
            margin-top: 30px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .header .close-button {
            font-size: 1.5rem;
            background: none;
            border: none;
            color: #6c757d;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .header .close-button:hover {
            color: #000;
        }

        .section-title {
            font-weight: bold;
            margin: 20px 0;
        }

        .question {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .question label {
            flex: 1;
        }

        .options {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
        }

        #newQuestionContainer {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        #saveButton {
            margin-left: auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h2>Анкета</h2>
            <button id="closeButton" class="close-button" onclick="window.location.href='/users/profile.php';">&times;</button>
        </div>

        <div>
            <p><strong>Пациент:</strong> Анна Смирнова Валерьевна</p>
        </div>

        <!-- Add new question -->
        <div id="newQuestionContainer">
            <input type="text" id="newQuestionInput" class="form-control" placeholder="Добавить вопрос">
            <button id="addQuestionButton" class="btn btn-secondary">Добавить</button>
        </div>

        <!-- Section title -->
        <h3 class="section-title">Перенесенные и сопутствующие заболевания</h3>

        <!-- Questions container -->
        <form id="questionsForm">
            <div class="question">
                <label>Бронхиальная астма</label>
                <div class="options">
                    <input type="radio" name="disease1" value="yes"> Да
                    <input type="radio" name="disease1" value="no"> Нет
                    <input type="radio" name="disease1" value="unknown" checked> Неизвестно
                </div>
            </div>
            <div class="question">
                <label>Были операции</label>
                <div class="options">
                    <input type="radio" name="disease2" value="yes"> Да
                    <input type="radio" name="disease2" value="no"> Нет
                    <input type="radio" name="disease2" value="unknown" checked> Неизвестно
                </div>
            </div>
            <div class="question">
                <label for="disease3">Работа связана с вредными факторами</label>
                <div class="options">
                    <input type="radio" name="disease3" value="yes"> Да
                    <input type="radio" name="disease3" value="no"> Нет
                    <input type="radio" name="disease3" value="unknown" checked> Неизвестно
                </div>
            </div>
            <div class="question">
                <label for="disease4">Глаукома (повышение внутриглазного давления)</label>
                <div class="options">
                    <input type="radio" name="disease4" value="yes"> Да
                    <input type="radio" name="disease4" value="no"> Нет
                    <input type="radio" name="disease4" value="unknown" checked> Неизвестно
                </div>
            </div>
            <div class="question">
                <label for="disease5">Головные боли (в т.ч. беспричинные)</label>
                <div class="options">
                    <input type="radio" name="disease5" value="yes"> Да
                    <input type="radio" name="disease5" value="no"> Нет
                    <input type="radio" name="disease5" value="unknown" checked> Неизвестно
                </div>
            </div>
            <div class="question">
                <label for="disease6">Грибковые заболевания</label>
                <div class="options">
                    <input type="radio" name="disease6" value="yes"> Да
                    <input type="radio" name="disease6" value="no"> Нет
                    <input type="radio" name="disease6" value="unknown" checked> Неизвестно
                </div>
            </div>
            <div class="question">
                <label for="disease7">Диарея (поносы)</label>
                <div class="options">
                    <input type="radio" name="disease7" value="yes"> Да
                    <input type="radio" name="disease7" value="no"> Нет
                    <input type="radio" name="disease7" value="unknown" checked> Неизвестно
                </div>
            </div>
            <div class="question">
                <label for="disease8">Длительная необъяснимая лихорадка</label>
                <div class="options">
                    <input type="radio" name="disease8" value="yes"> Да
                    <input type="radio" name="disease8" value="no"> Нет
                    <input type="radio" name="disease8" value="unknown" checked> Неизвестно
                </div>
            </div>
            <div class="question">
                <label for="disease9">Заболевание желудочно-кишечного тракта</label>
                <div class="options">
                    <input type="radio" name="disease9" value="yes"> Да
                    <input type="radio" name="disease9" value="no"> Нет
                    <input type="radio" name="disease9" value="unknown" checked> Неизвестно
                </div>
            </div>
            <div class="question">
                <label for="disease10">Заболевание кожи</label>
                <div class="options">
                    <input type="radio" name="disease10" value="yes"> Да
                    <input type="radio" name="disease10" value="no"> Нет
                    <input type="radio" name="disease10" value="unknown" checked> Неизвестно
                </div>
            </div>
            <div class="question">
                <label for="disease11">Заболевание крови</label>
                <div class="options">
                    <input type="radio" name="disease11" value="yes"> Да
                    <input type="radio" name="disease11" value="no"> Нет
                    <input type="radio" name="disease11" value="unknown" checked> Неизвестно
                </div>
            </div>
            <div class="question">
                <label for="disease12">Заболевание легких</label>
                <div class="options">
                    <input type="radio" name="disease12" value="yes"> Да
                    <input type="radio" name="disease12" value="no"> Нет
                    <input type="radio" name="disease12" value="unknown" checked> Неизвестно
                </div>
            </div>
            <div class="question">
                <label for="disease13">Заболевание печени</label>
                <div class="options">
                    <input type="radio" name="disease13" value="yes"> Да
                    <input type="radio" name="disease13" value="no"> Нет
                    <input type="radio" name="disease13" value="unknown" checked> Неизвестно
                </div>
            </div>
            <div class="question">
                <label for="disease14">Заболевание почек</label>
                <div class="options">
                    <input type="radio" name="disease14" value="yes"> Да
                    <input type="radio" name="disease14" value="no"> Нет
                    <input type="radio" name="disease14" value="unknown" checked> Неизвестно
                </div>
            </div>
        </form>
        <div class="d-flex justify-content-end mt-3">
            <button id="saveButton" class="btn btn-primary">Сохранить</button>
        </div>
    </div>

    <script>
        // Add new question dynamically
        document.getElementById('addQuestionButton').addEventListener('click', function () {
            const questionText = document.getElementById('newQuestionInput').value.trim();

            if (questionText !== '') {
                const questionContainer = document.createElement('div');
                questionContainer.className = 'question';
                questionContainer.innerHTML = `
                    <label>${questionText}</label>
                    <div class="options">
                        <input type="radio" name="${questionText}" value="yes"> Да
                        <input type="radio" name="${questionText}" value="no"> Нет
                        <input type="radio" name="${questionText}" value="unknown" checked> Неизвестно
                    </div>
                `;

                document.getElementById('questionsForm').appendChild(questionContainer);
                document.getElementById('newQuestionInput').value = ''; // Clear input
            } else {
                alert('Введите текст вопроса');
            }
        });

        // Handle save button
        document.getElementById('saveButton').addEventListener('click', function () {
            const formData = new FormData(document.getElementById('questionsForm'));
            const savedData = {};

            for (let [key, value] of formData.entries()) {
                savedData[key] = value;
            }

            console.log('Saved data:', savedData);
            alert('Анкета сохранена!');
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
