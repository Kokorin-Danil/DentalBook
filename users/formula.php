<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Формула зубов | DentalBook</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        /* Стили навигационного меню */
        #sidebar {
            width: 250px;
            background-color: #f8f9fa;
            padding: 20px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            overflow-y: auto;
            border-right: 1px solid #ddd;
            box-shadow: 2px 0 8px rgba(0, 0, 0, 0.05);
        }

        #sidebar h4 {
            font-weight: bold;
            color: #007bff;
            text-align: center;
            margin-bottom: 1.5rem;
        }

        #sidebar a {
            font-size: 1rem;
            color: #495057;
            display: flex;
            align-items: center;
            text-decoration: none;
            margin-bottom: 15px;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }

        #sidebar a:hover {
            background-color: #e9ecef;
            color: #007bff;
        }

        #sidebar a i {
            font-size: 1.2rem;
            margin-right: 10px;
        }

        /* Контент страницы */
        #content {
            margin-left: 270px;
            padding: 20px;
            background-color: #f4f6f9;
            min-height: 100vh;
        }

        body {
            background-color: #f4f6f9;
        }

        .header h2 {
            margin: 0;
            font-size: 1.8rem;
            color: #343a40;
            border-bottom: 2px solid #ddd;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .patient-info {
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .tabs {
            margin-bottom: 20px;
        }

        .tabs .nav-tabs .nav-link {
            color: #495057;
            margin-right: 5px;
            border-radius: 5px;
        }

        .tabs .nav-tabs .nav-link.active {
            color: #ffffff;
            background-color: #007bff;
        }

        .table-container {
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .btn-add {
            margin-bottom: 15px;
        }

        .profile-card {
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        .profile-icon {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 150px;
            width: 150px;
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 50%;
            margin: auto;
        }

        .actions button {
            margin-right: 10px;
        }

        .modal-content {
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .btn-primary {
            background: linear-gradient(45deg, #007bff, #0056b3);
            border: none;
        }

        .btn-primary:hover {
            background: linear-gradient(45deg, #0056b3, #003f88);
        }
        .formula-container {
            padding: 20px;
            background-color: #eef4fc;
            border-radius: 8px;
            margin-top: 20px;
        }
        .tooth-row {
            display: flex;
            justify-content: center;
            margin-bottom: 10px;
        }
        .tooth {
            width: 50px;
            height: 70px;
            margin: 5px;
            text-align: center;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            position: relative;
            cursor: pointer;
        }
        .tooth:hover {
            transform: scale(1.1);
            border-color: #007bff;
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
            margin-top: 20px;
        }
        .tooth.treatment {
            background-color: #ffc107; /* Желтый - лечение */
        }
        .tooth.extraction {
            background-color: #ff6f61; /* Красный - удаление */
        }
        .tooth.cleaning {
            background-color: #17a2b8; /* Голубой - чистка */
        }
        .tooth.crown {
            background-color: #6f42c1; /* Фиолетовый - коронка */
        }
        .controls {
            text-align: center;
            margin-bottom: 20px;
        }
        .controls button {
            margin: 0 5px;
        }
    </style>
</head>
<body>
    <?php include 'profile.php'; ?>
    
        <div class="container mt-5">
            <!-- Кнопки управления -->
            <div class="controls">
                <button class="btn btn-warning" onclick="setProcedure('treatment')"><i class="fas fa-tools"></i> Лечение</button>
                <button class="btn btn-danger" onclick="setProcedure('extraction')"><i class="fas fa-times-circle"></i> Удаление</button>
                <button class="btn btn-info" onclick="setProcedure('cleaning')"><i class="fas fa-brush"></i> Чистка</button>
                <button class="btn btn-primary" onclick="setProcedure('crown')"><i class="fas fa-crown"></i> Коронка</button>
                <button class="btn btn-secondary" onclick="clearProcedure()"><i class="fas fa-eraser"></i> Очистить</button>
            </div>

            <div class="formula-container">
                <!-- Верхняя челюсть -->
                <div class="tooth-row">
                    <script>
                        for (let i = 18; i >= 11; i--) {
                            document.write(`<div class="tooth" data-tooth="${i}" onclick="selectTooth(this)">
                                <div class="number">${i}</div>
                                <div class="icon">🦷</div>
                            </div>`);
                        }
                    </script>
                </div>
                <div class="tooth-row">
                    <script>
                        for (let i = 21; i <= 28; i++) {
                            document.write(`<div class="tooth" data-tooth="${i}" onclick="selectTooth(this)">
                                <div class="number">${i}</div>
                                <div class="icon">🦷</div>
                            </div>`);
                        }
                    </script>
                </div>
                <!-- Нижняя челюсть -->
                <div class="tooth-row">
                    <script>
                        for (let i = 41; i <= 48; i++) {
                            document.write(`<div class="tooth" data-tooth="${i}" onclick="selectTooth(this)">
                                <div class="number">${i}</div>
                                <div class="icon">🦷</div>
                            </div>`);
                        }
                    </script>
                </div>
                <div class="tooth-row">
                    <script>
                        for (let i = 38; i >= 31; i--) {
                            document.write(`<div class="tooth" data-tooth="${i}" onclick="selectTooth(this)">
                                <div class="number">${i}</div>
                                <div class="icon">🦷</div>
                            </div>`);
                        }
                    </script>
                </div>
            </div>
        </div>

<script>
    let selectedTooth = null;
    let procedure = null;

    // Выбор зуба
    function selectTooth(element) {
        if (selectedTooth) {
            selectedTooth.classList.remove('active');
        }
        selectedTooth = element;
        selectedTooth.classList.add('active');
    }

    // Установка процедуры
    function setProcedure(proc) {
        if (!selectedTooth) {
            alert('Выберите зуб перед применением процедуры!');
            return;
        }
        procedure = proc;
        selectedTooth.className = `tooth ${proc}`;
    }

    // Очистка процедуры
    function clearProcedure() {
        if (!selectedTooth) {
            alert('Выберите зуб для очистки!');
            return;
        }
        selectedTooth.className = 'tooth';
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
