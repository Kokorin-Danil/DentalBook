<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style.css">
    <title>Medical History</title>
</head>
<body>
    <header class="bg-light py-2">
        <div class="container">
            <h1 class="display-6">Medical Card</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Medical History</li>
                </ol>
            </nav>
        </div>
    </header>

    <main class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <h2 class="mb-4">Medical History</h2>

                <!-- Form for adding new diagnosis -->
                <form action="#" method="post" class="mb-4">
                    <div class="row mb-2">
                        <label for="diagnosisDate" class="col-sm-2 col-form-label">Дата и время визита:</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" id="diagnosisDate" required>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label for="diagnosisText" class="col-sm-2 col-form-label">Жалобы Пациента:</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" id="diagnosisText" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label for="treatment" class="col-sm-2 col-form-label">Treatment:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="treatment" required>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label for="analysis" class="col-sm-2 col-form-label">Lab Results:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="analysis" required>
                        </div>
                    </div>
                    <div class="row justify-content-end">
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary">Add Diagnosis</button>
                        </div>
                    </div>
                </form>

                <!-- Table for displaying medical history -->
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Diagnosis</th>
                            <th>Treatment</th>
                            <th>Lab Results</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>2023-01-01</td>
                            <td>Gastritis</td>
                            <td>Antibiotics</td>
                            <td>Blood test</td>
                        </tr>
                        <!-- Add more rows as needed -->
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <footer class="bg-light py-3 mt-4">
        <div class="container">
            <p>&copy; 2024 Your Company Name. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>
