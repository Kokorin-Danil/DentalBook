<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Формула зубов | DentalBook</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .formula-container {
            padding: 20px;
            background-color: #eef4fc;
            border-radius: 8px;
            margin-top: 20px;
        }
        .tooth-row {
            display: flex;
            justify-content: center;
            margin-bottom: 15px;
        }
        .tooth {
            width: 60px;
            height: 80px;
            margin: 5px;
            text-align: center;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 8px;
            position: relative;
            cursor: pointer;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .tooth.selected {
            border-color: #007bff;
            box-shadow: 0 0 5px #007bff;
        }
        .tooth .number {
            font-size: 12px;
            position: absolute;
            top: 5px;
            left: 5px;
            color: #555;
        }
        .tooth .icon {
            font-size: 24px;
            color: #333;
            margin-bottom: 5px;
        }
        .tooth .status-icons {
            display: flex;
            flex-wrap: wrap;
            gap: 2px;
            justify-content: center;
            width: 100%;
        }
        .status-icons .status {
            width: 16px;
            height: 16px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            color: #fff;
        }
        .controls {
            text-align: center;
            margin-bottom: 20px;
        }
        .controls button {
            margin: 0 5px;
        }
        /* Цвета для статусов */
        .status.treatment { background-color: #ffc107; } /* Желтый */
        .status.extraction { background-color: #dc3545; } /* Красный */
        .status.crown { background-color: #007bff; } /* Синий */
        .status.caries { background-color: #000000; } /* Черный */
        .status.filling { background-color: #28a745; } /* Зеленый */
        .status.prosthesis { background-color: #8b4513; } /* Коричневый */
        .status.cyst { background-color: #9b59b6; } /* Фиолетовый */
    </style>
</head>
<body>
    <?php include 'profile.php'; ?>
    <?php include 'navbar.php'; ?>

    <div class="container mt-5">
        <!-- Кнопки управления -->
        <div class="controls">
            <button class="btn btn-warning" onclick="setProcedure('treatment')"><i class="fas fa-tools"></i> Лечение</button>
            <button class="btn btn-danger" onclick="setProcedure('extraction')"><i class="fas fa-times-circle"></i> Удаление</button>
            <button class="btn btn-primary" onclick="setProcedure('crown')"><i class="fas fa-crown"></i> Коронка</button>
            <button class="btn btn-dark" onclick="setProcedure('caries')"><i class="fas fa-bug"></i> Кариес</button>
            <button class="btn btn-success" onclick="setProcedure('filling')"><i class="fas fa-check-circle"></i> Пломба</button>
            <button class="btn btn-brown" style="background-color: #8b4513; color: white;" onclick="setProcedure('prosthesis')"><i class="fas fa-teeth-open"></i> Протез</button>
            <button class="btn btn-purple" style="background-color: #9b59b6; color: white;" onclick="setProcedure('cyst')"><i class="fas fa-disease"></i> Киста</button>
            <button class="btn btn-light" onclick="clearProcedures()"><i class="fas fa-eraser"></i> Очистить</button>
            <button class="btn btn-success" onclick="saveTeethStatuses()"><i class="fas fa-save"></i> Сохранить</button>
        </div>

        <div class="formula-container" id="formulaContainer">
            <!-- Верхняя и нижняя челюсти будут загружены динамически -->
        </div>
    </div>

<script>
    const statusColors = {
        "Лечение": "treatment",
        "Удаление": "extraction",
        "Коронка": "crown",
        "Кариес": "caries",
        "Пломба": "filling",
        "Протез": "prosthesis",
        "Киста": "cyst"
    };

    const selectedTeeth = new Set();

    function toggleToothSelection(element) {
        const toothId = element.getAttribute('data-tooth');
        if (selectedTeeth.has(toothId)) {
            selectedTeeth.delete(toothId);
            element.classList.remove('selected');
        } else {
            selectedTeeth.add(toothId);
            element.classList.add('selected');
        }
    }

    function setProcedure(proc) {
        if (selectedTeeth.size === 0) {
            alert('Выберите хотя бы один зуб перед применением процедуры!');
            return;
        }

        selectedTeeth.forEach((toothId) => {
            const toothElement = document.querySelector(`.tooth[data-tooth="${toothId}"]`);
            const iconsContainer = toothElement.querySelector('.status-icons');
            const currentStatuses = iconsContainer.querySelectorAll('.status');

            if (currentStatuses.length >= 3) {
                alert(`Нельзя добавить больше 3 статусов к зубу ${toothId}!`);
                return;
            }

            if (!iconsContainer.querySelector(`.${proc}`)) {
                const icon = document.createElement('div');
                icon.className = `status ${proc}`;
                iconsContainer.appendChild(icon);
            }
        });
    }

    function clearProcedures() {
        if (selectedTeeth.size === 0) {
            alert('Выберите зубы для очистки!');
            return;
        }

        selectedTeeth.forEach((toothId) => {
            const toothElement = document.querySelector(`.tooth[data-tooth="${toothId}"]`);
            toothElement.querySelector('.status-icons').innerHTML = '';
        });
    }

    async function loadTeethStatuses() {
        const patientCardId = new URLSearchParams(window.location.search).get('patientCardId');
        if (!patientCardId) {
            alert('ID карты пациента не указан.');
            return;
        }

        try {
            const response = await fetch(`http://localhost:3003/api/patient-cards/teeth/get/${patientCardId}`);
            const teethData = await response.json();

            renderTeeth(teethData);
        } catch (error) {
            console.error('Ошибка при загрузке данных зубов:', error);
            alert('Не удалось загрузить данные зубов.');
        }
    }

    function renderTeeth(teeth) {
        const formulaContainer = document.getElementById('formulaContainer');
        formulaContainer.innerHTML = '';

        const upperJaw1 = document.createElement('div');
        upperJaw1.className = 'tooth-row';
        const upperJaw2 = document.createElement('div');
        upperJaw2.className = 'tooth-row';
        const lowerJaw1 = document.createElement('div');
        lowerJaw1.className = 'tooth-row';
        const lowerJaw2 = document.createElement('div');
        lowerJaw2.className = 'tooth-row';

        teeth.forEach(tooth => {
            const toothElement = document.createElement('div');
            toothElement.className = 'tooth';
            toothElement.setAttribute('data-tooth', tooth.toothNumber);
            toothElement.addEventListener('click', () => toggleToothSelection(toothElement));

            const statusesHTML = tooth.statuses
                .map(statusObj => `<div class="status ${statusColors[statusObj.status] || ''}"></div>`)
                .join('');

            toothElement.innerHTML = `
                <div class="number">${tooth.toothNumber}</div>
                <div class="icon">🦷</div>
                <div class="status-icons">${statusesHTML}</div>
            `;

            if (tooth.toothNumber >= 11 && tooth.toothNumber <= 18) upperJaw1.appendChild(toothElement);
            if (tooth.toothNumber >= 21 && tooth.toothNumber <= 28) upperJaw2.appendChild(toothElement);
            if (tooth.toothNumber >= 31 && tooth.toothNumber <= 38) lowerJaw2.appendChild(toothElement);
            if (tooth.toothNumber >= 41 && tooth.toothNumber <= 48) lowerJaw1.appendChild(toothElement);
        });

        formulaContainer.appendChild(upperJaw1);
        formulaContainer.appendChild(upperJaw2);
        formulaContainer.appendChild(lowerJaw1);
        formulaContainer.appendChild(lowerJaw2);
    }

    async function saveTeethStatuses() {
        const patientCardId = new URLSearchParams(window.location.search).get('patientCardId');
        if (!patientCardId) {
            alert('ID карты пациента не указан.');
            return;
        }

        const teethData = [];
        document.querySelectorAll('.tooth').forEach(toothElement => {
            const toothNumber = toothElement.getAttribute('data-tooth');
            const statuses = Array.from(toothElement.querySelectorAll('.status')).map(statusIcon => {
                return Object.keys(statusColors).find(key => statusColors[key] === statusIcon.classList[1]);
            });

            teethData.push({ toothNumber, statuses });
        });

        try {
            const response = await fetch(`http://localhost:3003/api/patient-cards/teeth/update/${patientCardId}`, {
                method: 'PUT',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ teeth: teethData })
            });

            if (!response.ok) throw new Error('Ошибка сохранения данных зубов.');

            alert('Данные зубов успешно сохранены!');
        } catch (error) {
            console.error('Ошибка при сохранении данных:', error);
            alert('Не удалось сохранить данные зубов.');
        }
    }

    document.addEventListener('DOMContentLoaded', loadTeethStatuses);
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
