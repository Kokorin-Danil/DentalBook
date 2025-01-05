<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Запись на прием к стоматологу</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <h1>Запись на прием к стоматологу</h1>

        <!-- Форма ввода данных пациента -->
        <form id="appointmentForm">
            <div class="mb-3">
                <label for="patientName" class="form-label">ФИО пациента:</label>
                <input type="text" class="form-control" id="patientName" required>
            </div>

            <div class="mb-3">
                <label for="patientEmail" class="form-label">Электронная почта:</label>
                <input type="email" class="form-control" id="patientEmail" required>
            </div>

            <div class="mb-3">
                <label for="patientPhone" class="form-label">Номер телефона:</label>
                <input type="tel" class="form-control" id="patientPhone" placeholder="+7 (___) ___-__-__" required>
            </div>

            <div class="mb-3">
                <label for="date" class="form-label">Дата:</label>
                <input type="date" class="form-control" id="date" required>
            </div>

            <div class="mb-3">
                <label for="time" class="form-label">Время:</label>
                <input type="time" class="form-control" id="time" required>
            </div>

            <div class="mb-3">
                <label for="reason" class="form-label">Причина посещения:</label>
                <textarea class="form-control" id="reason" rows="3" required></textarea>
            </div>

            <!-- Выбор стоматолога -->
            <div class="mb-3">
                <label for="dentistSelect" class="form-label">Выберите стоматолога:</label>
                <select class="form-select" id="dentistSelect" required>
                    <option value="">-- Выберите стоматолога --</option>
                    <option value="dentist1">Стоматолог 1</option>
                    <option value="dentist2">Стоматолог 2</option>
                    <option value="dentist3">Стоматолог 3</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary w-100 mt-4">Записаться на прием</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="script src="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script>
        document.getElementById('appointmentForm').addEventListener('submit', async (e) => {
            e.preventDefault();

            if (!appointmentForm.checkValidity()) {
                appointmentForm.reportValidity();
                return;
            }

            const formData = new FormData(appointmentForm);
            try {
                const response = await fetch('/save_appointment', {
                    method: 'POST',
                    body: formData
                });
                if (!response.ok) {
                    const errorData = await response.json();
                    alert(`Ошибка при записи на прием: ${errorData.message || response.statusText}`);
                } else {
                    alert('Вы успешно записались на прием!');
                    appointmentForm.reset();
                }
            } catch (error) {
                console.error('Ошибка:', error);
                alert('Произошла ошибка при записи. Попробуйте позже.');
            }
        });
    </script>
</body>
</html>
