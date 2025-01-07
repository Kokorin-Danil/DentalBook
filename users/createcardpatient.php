<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Font Awesome -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
        crossorigin="anonymous" referrerpolicy="no-referrer">

    <title>Создание карты пациента</title>
    <style>
        body {
            background-color: #f4f6f9;
        }

        .container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-top: 30px;
        }

        h1 {
            color: #343a40;
        }

        .form-label {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <?php include 'navbar.php'; ?>
    <div class="container">
        <h1 class="mb-4">Создание карты пациента</h1>
        <div id="responseMessage"></div> <!-- Для отображения ответа от сервера -->
        <form id="patientForm">
            <!-- Personal Information -->
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="firstName" class="form-label">Имя:</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="text" class="form-control" id="firstName" placeholder="Введите имя" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="lastName" class="form-label">Фамилия:</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="text" class="form-control" id="lastName" placeholder="Введите фамилию" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="patronymic" class="form-label">Отчество:</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="text" class="form-control" id="patronymic" placeholder="Введите отчество">
                    </div>
                </div>
            </div>

            <!-- Additional Details -->
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="gender" class="form-label">Пол:</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-venus-mars"></i></span>
                        <select class="form-select" id="gender" required>
                            <option value="">Выберите пол</option>
                            <option value="male">Мужской</option>
                            <option value="female">Женский</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="birthDate" class="form-label">Дата рождения:</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                        <input type="date" class="form-control" id="birthDate" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="address" class="form-label">Адрес:</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                        <input type="text" class="form-control" id="address" placeholder="Введите адрес" required>
                    </div>
                </div>
            </div>

            <!-- Contact Details -->
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="email" class="form-label">Email:</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input type="email" class="form-control" id="email" placeholder="example@email.com" required>
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="phone" class="form-label">Телефон:</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                        <input type="tel" class="form-control" id="phone" placeholder="+7 (___) ___-__-__" required>
                    </div>
                </div>
            </div>

            <!-- Identification -->
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="policy" class="form-label">Полис:</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-file-alt"></i></span>
                        <input type="text" class="form-control" id="policy" placeholder="Введите номер полиса">
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="snils" class="form-label">СНИЛС:</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                        <input type="text" class="form-control" id="snils" placeholder="Введите СНИЛС">
                    </div>
                </div>
                <div class="col-md-4">
                    <label for="passport" class="form-label">Паспорт:</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-id-badge"></i></span>
                        <input type="text" class="form-control" id="passport" placeholder="Введите данные паспорта">
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-4"><i class="fas fa-check"></i> Сохранить карту пациента</button>
        </form>
    </div>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>

    <script>
        function getCookie(name) {
            const value = `; ${document.cookie}`;
            const parts = value.split(`; ${name}=`);
            if (parts.length === 2) return parts.pop().split(';').shift();
        }

        const token = getCookie('token');
        
        if (!token) {
            alert('Вы не авторизованы. Пожалуйста, выполните вход.');
            window.location.href = '/auth.php';
        }

        document.getElementById('patientForm').addEventListener('submit', async (event) => {
            event.preventDefault();

            const patientData = {
                firstName: document.getElementById('firstName').value,
                lastName: document.getElementById('lastName').value,
                patronymic: document.getElementById('patronymic').value,
                gender: document.getElementById('gender').value,
                dateOfBirth: document.getElementById('birthDate').value,
                address: document.getElementById('address').value,
                email: document.getElementById('email').value,
                phoneNumber: document.getElementById('phone').value,
                policyNumber: document.getElementById('policy').value,
                snils: document.getElementById('snils').value,
                passport: document.getElementById('passport').value,
            };

            try {
                const response = await fetch('http://127.0.0.1:3003/api/patient-cards/create', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        Authorization: `Bearer ${token}`,
                    },
                    body: JSON.stringify(patientData),
                });

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.message || 'Ошибка при создании карты пациента');
                }

                document.getElementById('responseMessage').innerHTML = `
                    <div class="alert alert-success">
                        <strong>${data.message}</strong><br>
                        <strong>Email клиента:</strong> ${data.clientCredentials.email}<br>
                        <strong>Пароль клиента:</strong> ${data.clientCredentials.password}
                    </div>
                `;

                document.getElementById('patientForm').reset();
            } catch (error) {
                document.getElementById('responseMessage').innerHTML = `
                    <div class="alert alert-danger">Ошибка: ${error.message}</div>
                `;
            }
        });
    </script>
</body>

</html>
