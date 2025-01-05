<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Анализ пациента | Стоматология</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Анализ пациента | Стоматология</h1>
        
        <!-- Форма ввода данных о пациенте -->
        <div class="mb-4">
            <label for="patientName" class="form-label">ФИО пациента:</label>
            <input type="text" class="form-control" id="patientName" required>
        </div>
        
        <div class="mb-4">
            <label for="analysisDate" class="form-label">Дата анализа:</label>
            <input type="date" class="form-control" id="analysisDate" required>
        </div>
        
        <!-- Форма ввода типа анализа -->
        <div class="mb-4">
            <label for="analysisType" class="form-label">Тип анализа:</label>
            <select class="form-select" id="analysisType" required>
                <option value="">Выберите тип анализа</option>
                <option value="ЗБ">Зубной биланц</option>
                <option value="ПФР">Периферический флюорография</option>
                <option value="ОМРТ">Обычная магнитно-резонансная томография</option>
                <option value="Радиограмма">Радиограмма зубов</option>
                <option value="ЦВТ">Компьютерная томография</option>
                <option value="ОБЖС">Общий билирубин и желчноканальный желчь (стоматологический)</option>
            </select>
        </div>
        
        <!-- Форма ввода результатов анализа -->
        <div class="mb-4">
            <label for="analysisResults" class="form-label">Результаты:</label>
            <textarea class="form-control" id="analysisResults" rows="3" required></textarea>
        </div>
        
        <!-- Загрузка рентгеновских снимков -->
        <div class="mb-4">
            <label for="xrayFiles" class="form-label">Загрузить рентгеновские снимки:</label>
            <input type="file" id="xrayFiles" accept="image/*" required multiple class="form-control">
        </div>

        <!-- Контейнер для отображения загруженных изображений -->
        <div id="imageCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="" class="img-fluid">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#imageCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Прежнее</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#imageCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Следующее</span>
            </button>
        </div>


        <!-- Кнопка сохранения -->
        <button type="submit" class="btn btn-primary w-100">Сохранить анализ</button>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"></script>
    <script>
        function showImages() {
            console.log('Файлы выбраны:', this.files);
            if (!this.files) return;

            const carousel = document.getElementById('imageCarousel');
            const items = Array.from(carousel.querySelectorAll('.carousel-item'));

            items.forEach((item, index) => {
                const file = this.files[index];
                if (!file) return;

                const reader = new FileReader();
                
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'img-fluid';
                    
                    item.innerHTML = '';
                    item.appendChild(img);
                }
                
                reader.readAsDataURL(file);
            });
        }
        document.getElementById('xrayFiles').addEventListener('change', showImages);
    </script>

</body>
</html>
