# DentalBook

**Веб-приложение для автоматизации работы стоматологической клиники**: электронные амбулаторные карты, зубная формула, расписание врачей, осмотры, заметки и снимки.

Бэкенд — Node.js + Express + Sequelize (MySQL). Фронтенд — PHP-страницы с Bootstrap 5, которые работают с API через `fetch`.

> Все данные на скриншотах — **вымышленные**: реальные пациенты, их фотографии и рентген-снимки в скриншоты не попадали.

---

## Скриншоты

### Авторизация

![Страница авторизации](docs/screenshots/01-auth.png)

### Управление персоналом и пациентами (администратор)

<img src="docs/screenshots/02-admin-doctors.png" width="49%" alt="Список врачей">
<img src="docs/screenshots/03-admin-patients.png" width="49%" alt="Список пациентов">

<img src="docs/screenshots/04-admin-managers.png" width="49%" alt="Список администраторов приёма">
<img src="docs/screenshots/06-patient-cards.png" width="49%" alt="Список карт пациентов">

### Расписание врачей

<img src="docs/screenshots/05-calendar.png" width="100%" alt="Расписание на день">

### Амбулаторная карта

<img src="docs/screenshots/07-patient-card-visits.png" width="49%" alt="История визитов пациента">
<img src="docs/screenshots/12-patient-data.png" width="49%" alt="Персональные данные пациента">

### Зубная формула

<img src="docs/screenshots/08-dental-formula.png" width="100%" alt="Зубная формула по системе FDI">

### Анкета пациента

<img src="docs/screenshots/16-survey.png" width="49%" alt="Медицинская анкета пациента">
<img src="docs/screenshots/10-snapshots.png" width="49%" alt="Снимки пациента">

### Заметки врача и осмотры

<img src="docs/screenshots/09-notes.png" width="49%" alt="Заметки врача">
<img src="docs/screenshots/11-snapshot-preview.png" width="49%" alt="Предпросмотр снимка">

<img src="docs/screenshots/13-examination-sheets.png" width="49%" alt="Карта осмотров">
<img src="docs/screenshots/14-new-examination.png" width="49%" alt="Форма первичного осмотра">

### Профили

<img src="docs/screenshots/15-doctor-profile.png" width="49%" alt="Профиль врача">
<img src="docs/screenshots/17-client-view.png" width="49%" alt="Личный кабинет пациента">

---

## Возможности

| Раздел | Что реализовано |
|---|---|
| **Амбулаторная карта** | Регистрация пациента, полис/СНИЛС/паспорт, адрес, телефон, история визитов, статус визита (подтверждён / не подтверждён / отменён) |
| **Зубная формула** | Полная схема 32 зубов (система FDI) с набором статусов на каждый зуб: кариес, пломба, лечение, удаление, протез, коронка, киста |
| **Расписание** | Дневное, недельное и месячное расписание по врачам; проверка пересечений визитов и длительности лечения при записи |
| **Осмотры** | Четыре типа карт осмотра: «Первичный осмотр», «Повторный визит», «Профилактическая чистка», «Экстренный случай» |
| **Заметки врача** | Текстовые записи с указанием важности, привязанные к карте пациента |
| **Снимки** | Загрузка снимков (Multer), привязка к визиту и номерам зубов, предпросмотр в модальном окне |
| **Анкета пациента** | Медицинский опрос: боли, чувствительность, кровоточивость дёсен, привычки, аллергии, анестезия |
| **Учёт персонала** | Администратор управляет врачами и администраторами приёма; у каждого врача — профиль, специализация, расписание, аватар |
| **Роли и доступ** | Четыре роли с разными наборами прав и своими наборами экранов |

## Роли

| Роль | Вход после авторизации | Возможности |
|---|---|---|
| `admin` | `/adminpanel/doctors.php` | Персонал, пациенты, администраторы приёма, удаление записей и снимков, полный доступ к картам |
| `doctor` | `/personal/profiledoctor.php` | Своё расписание, карты пациентов, зубная формула, заметки, снимки, осмотры, ведение карты |
| `manager` | `/kalendar/kalendar.php` | Расписание клиники, карточки пациентов |
| `client` | `/users/view.php?patientCardId=N` | Своя карта, история визитов, анкета |

---

## Технологии

**Backend**

- Node.js 18+, ES Modules
- Express 4 — REST API
- Sequelize 6 + MySQL (драйвер `mysql2`)
- JWT (`jsonwebtoken`) — авторизация по ролям, middleware `authenticateToken`
- `bcrypt` — хеширование паролей
- `multer` — загрузка аватаров и снимков
- `dayjs` — работа с датами и длительностью визитов
- `express-validator`, `cors`, `dotenv`, `body-parser`

**Frontend**

- PHP (страницы и частичные шаблоны через `include`)
- Bootstrap 5, Font Awesome 6, Bootstrap Icons
- Vanilla JavaScript: `fetch`, `jwt-decode`, работа с DOM

---

## Структура проекта

```
DentalBook/
├── index.php                 # авторизация
├── logout.php
├── css/style.css
├── js/auth.js                # разбор JWT, получение токена из cookie
│
├── adminpanel/               # админ-панель: врачи, пациенты, менеджеры, navbar
├── inspection/               # формы осмотров: initial / repeatvisit / cleaning / danger
├── kalendar/                 # расписание: день / неделя / месяц
├── personal/                 # кабинет врача и сотрудника
├── users/                    # кабинет пациента, карта, формула, заметки, снимки, анкета
│
└── backend/
    ├── index.js              # точка входа Express, монтирование роутеров
    ├── package.json
    ├── admin/                # контроллер и роутер администратора
    ├── doctors/              # модель врача, контроллер, роутер
    ├── patientCard/          # модели карты, визитов, зубов, заметок, снимков, осмотров
    ├── users/                # модель пользователя, авторизация, роутер
    ├── utils/                # подключение к БД, конфиг, middleware
    └── uploads/              # загруженные аватары и снимки
```

## Схема базы данных

| Таблица | Назначение |
|---|---|
| `users` | Учётные записи: логин, хеш пароля, роль, пол, аватар |
| `doctors` | Профиль врача: ФИО, специализация, телефон, дата рождения |
| `patient_cards` | Амбулаторная карта: ФИО, дата рождения, контакты, адрес, полис, СНИЛС, паспорт |
| `visits` | Визиты: дата, время, тип (`Осмотр` / `Лечение` / `Консультация`), врач, статус (`Не подтверждён` / `Подтверждён` / `Отменён`) |
| `teeth` | Зубы пациента (32 позиции по FDI) |
| `tooth_statuses` | Статусы зубов (кариес, пломба, удаление и т. д.) |
| `patient_notes` | Заметки врача с указанием важности |
| `snapshots` | Снимки: файл, номера зубов, описание, привязка к визиту |
| `examination_sheets` | Карты осмотров четырёх типов |
| `medical_surveys` | Анкеты пациента |

---

## Запуск

### Требования

- Node.js 18+
- MySQL 8.0+ (совместимо с MariaDB 10.6+)
- PHP 8 + веб-сервер (Apache / XAMPP / OpenServer)

### 1. База данных

```sql
CREATE DATABASE dentalbook CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 2. Backend

```bash
cd backend
npm install
```

Создайте `backend/.env`:

```ini
HOST=127.0.0.1
PORT=3306
TABLE=dentalbook
JWT_SECRET=your_secret_key_here
```

Запуск:

```bash
npm run dev      # nodemon index.js
```

API поднимется на `http://localhost:3003`, схема таблиц создаётся автоматически при старте (`dbST.sync({ alter: true })`).

### 3. Frontend

Откройте корень репозитория как `DocumentRoot` в Apache/XAMPP и перейдите на `http://localhost/`.

> **Важно:** адрес API (`http://localhost:3003`) прописан в клиентском JavaScript. При изменении порта или хоста править нужно все точки обращения к API в `users/`, `adminpanel/`, `personal/`, `kalendar/`, `inspection/`.

### 4. Первый вход

Администратор создаётся запросом:

```http
POST /api/admin/create/admin
Content-Type: application/json

{ "firstName": "...", "lastName": "...", "patronymic": "...",
  "email": "admin@clinic.ru", "password": "...", "gender": "female" }
```

Дальше врачей и администраторов приёма можно добавлять из админ-панели.

---

## API (основные группы)

| Группа | Методы |
|---|---|
| Авторизация | `POST /api/users/login`, `GET /api/users/profile`, `GET /api/users/check/:patientCardId`, `POST /api/users/avatar/upload` |
| Карты пациентов | `POST /api/patient-cards/create`, `GET /api/patient-cards/get/all`, `GET /api/patient-cards/get/patient_profile/:id`, `DELETE /api/patient-cards/card/:id` |
| Визиты | `POST /api/patient-cards/visit/create`, `GET /api/patient-cards/visit/all/:id`, `PUT /api/patient-cards/visit/change/:visitId`, `GET /api/patient-cards/schedule/:date`, `GET /api/patient-cards/schedule/weekly/:from/:to`, `GET /api/patient-cards/schedule/monthly/:month` |
| Зубы | `GET /api/patient-cards/teeth/get/:patientCardId`, `PUT /api/patient-cards/teeth/update/:patientCardId` |
| Заметки | `POST /api/patient-cards/notes/create/:patientCardId`, `GET /api/patient-cards/notes/getall/:patientCardId` |
| Снимки | `POST /api/patient-cards/snapshots/create`, `GET /api/patient-cards/snapshots/getall/:patientCardId` |
| Осмотры | `POST /api/patient-cards/examinationsheet/create/:patientCardId`, `GET /api/patient-cards/examinationsheet/get/:patientCardId` |
| Анкета | `POST /api/patient-cards/survey`, `GET /api/patient-cards/survey/:patientCardId` |
| Врачи | `GET /api/doctors/profile`, `GET /api/doctors/shudle`, `GET /api/doctors/get/all`, `POST /api/doctors/avatar/upload` |
| Админка | `GET /api/admin/doctors/get`, `GET /api/admin/patients/get`, `GET /api/admin/manager/getall`, `POST /api/admin/manager/create`, `DELETE /api/admin/doctors/:id`, `DELETE /api/admin/visit/:visitId`, `DELETE /api/admin/snapshot/:id` |

---

## Особенности реализации

- **Фронтенд** — статические PHP-страницы. Логики на PHP почти нет: страницы подключают общие части (`navbar.php`, `profile.php`) через `include`, а всё общение с данными идёт из браузера через `fetch` к REST API.
- **Авторизация** — JWT в заголовке `Authorization: Bearer <token>`. Токен кладётся в `document.cookie`, роль читается из payload токена; сервер проверяет права в middleware `authenticateToken`.
- **Пароли** — только bcrypt-хеши, в открытом виде не хранятся.
- **Расписание** — при создании визита сервер проверяет пересечение с другими визитами врача и учитывает, что «лечение» занимает 60 минут, а осмотр/консультация — 30.
- **Скриншоты** сделаны с реально работающего приложения. Для запуска без установленного MySQL использовалась сборка на SQLite с предзаполненной демо-базой; код бэкенда при этом не менялся — заменён только драйвер подключения.

---


