<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Моя стоматологическая карта</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer">
</head>
<body>
    <div class="container">
        <header>
            <h1>Моя стоматологическая карта</h1>
        </header>
        <div class="row">
            <div class="col-md-6 card-section">
                <div class="card">
                    <div class="card-header"><i class="fas fa-user-alt"></i> Мои данные</div>
                    <div class="card-body">
                        <button type="button" class="btn btn-primary view-btn" data-bs-toggle="modal" data-bs-target="#patientInfoModal"><i class="fas fa-eye"></i> Посмотреть</button>
                    </div>
                </div>
            </div>

            <div class="col-md-6 card-section">
                <div class="card">
                    <div class="card-header"><i class="fas fa-list-ul"></i> История лечения</div>
                    <div class="card-body">
                        <button type="button" class="btn btn-primary view-btn" data-bs-toggle="modal" data-bs-target="#treatmentHistoryModal"><i class="fas fa-eye"></i> Посмотреть</button>
                    </div>
                </div>
            </div>

            <div class="col-md-6 card-section">
                <div class="card">
                    <div class="card-header"><i class="fas fa-x-ray"></i> Рентгеновские снимки</div>
                    <div class="card-body">
                        <button type="button" class="btn btn-primary view-btn" data-bs-toggle="modal" data-bs-target="#xrayModal"><i class="fas fa-eye"></i> Посмотреть</button>
                    </div>
                </div>
            </div>

            <div class="col-md-6 card-section">
                <div class="card">
                    <div class="card-header"><i class="fas fa-file-invoice"></i> Медицинские документы</div>
                    <div class="card-body">
                        <button type="button" class="btn btn-primary view-btn" data-bs-toggle="modal" data-bs-target="#documentsModal"><i class="fas fa-eye"></i> Посмотреть</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Модальное окно для информации о пациенте -->
        <div class="modal fade" id="patientInfoModal" tabindex="-1" aria-labelledby="patientInfoModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="patientInfoModalLabel"><i class="fas fa-info-circle"></i> Информация о пациенте</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong><i class="fas fa-user"></i> ФИО:</strong> Иванов Иван Иванович</p>
                        <p><strong><i class="fas fa-calendar-alt"></i> Дата рождения:</strong> 01.01.1980</p>
                        <p><strong><i class="fas fa-venus-mars"></i> Пол:</strong> Мужской</p>
                        <p><strong><i class="fas fa-phone"></i> Телефон:</strong> +7 (123) 456-78-90</p>
                        <p><strong><i class="fas fa-envelope"></i> Email:</strong> ivanivanovich@example.com</p>
                        <p><strong><i class="fas fa-map-marker-alt"></i> Адрес:</strong> г.Ижевск ул.Пушкина д.12</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> Закрыть</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Модальное окно для истории лечения -->
        <div class="modal fade" id="treatmentHistoryModal" tabindex="-1" aria-labelledby="treatmentHistoryModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="treatmentHistoryModalLabel"><i class="fas fa-list-ul"></i> История лечения</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Проблемы с зубами:</strong> Кариес, разбитый зуб</p>
                        <p><strong>Дата последнего посещения:</strong> 10.12.2024</p>
                        <p><strong>Рекомендации врача:</strong> Следующее профилактическое обслуживание 15.01.2025</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Модальное окно для рентгеновских снимков -->
        <div class="modal fade" id="xrayModal" tabindex="-1" aria-labelledby="xrayModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="xrayModalLabel"><i class="fas fa-x-ray"></i> Рентгеновские снимки</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                    </div>
                    <div class="modal-body">
                        <img src="path/to/xray-image.jpg" alt="Рентгеновский снимок" class="img-fluid">
                        <p><strong>Дата снимка:</strong> 10.12.2024</p>
                        <div class="mt-3">
                            <a href="#" id="downloadXrayLink" class="btn btn-primary">Скачать снимок</a>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Модальное окно для просмотра медицинских документов -->
        <div class="modal fade" id="documentsModal" tabindex="-1" aria-labelledby="documentsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="documentsModalLabel"><i class="fas fa-file-invoice"></i> Медицинские документы</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <label for="documentType" class="col-sm-2 col-form-label">Тип документа:</label>
                            <div class="col-sm-10">
                                <select class="form-select" id="documentType" onchange="updateDocument()">
                                    <option selected>Выберите тип документа</option>
                                    <option value="anamnesis">Анамнез пациента</option>
                                    <option value="treatmentPlan">Лечебная программа</option>
                                    <option value="analysisResults">Результаты анализов</option>
                                    <option value="treatmentProtocol">Протокол лечения</option>
                                </select>
                            </div>
                        </div>
                              
                <div class="row mb-3">
                    <label for="documentContent" class="col-sm-2 col-form-label">Содержимое документа:</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" id="documentContent" rows="10" readonly></textarea>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label for="documentFile" class="col-sm-2 col-form-label">Файл документа:</label>
                    <div class="col-sm-10">
                        <a href="#" id="downloadLink" class="btn btn-primary">Скачать</a>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="script crossorigin="anonymous"></script>
</body>
</html>

