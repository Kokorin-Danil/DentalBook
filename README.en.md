# DentalBook

**Web application for automating dental clinic operations**: electronic medical records, dental chart, doctor schedules, examinations, notes, and X-rays.

Backend — Node.js + Express + Sequelize (MySQL). Frontend — PHP pages with Bootstrap 5 that interact with the API via `fetch`.

> All data in screenshots is **fictional**: real patients, their photos, and X-ray images are not shown in the screenshots.

---

## Screenshots

### Authentication

![Authentication page](docs/screenshots/01-auth.png)

### Staff and patient management (Administrator)

<img src="docs/screenshots/02-admin-doctors.png" width="49%" alt="Doctors list">
<img src="docs/screenshots/03-admin-patients.png" width="49%" alt="Patients list">

<img src="docs/screenshots/04-admin-managers.png" width="49%" alt="Reception administrators list">
<img src="docs/screenshots/06-patient-cards.png" width="49%" alt="Patient cards list">

### Doctor schedule

<img src="docs/screenshots/05-calendar.png" width="100%" alt="Daily schedule">

### Electronic medical record

<img src="docs/screenshots/07-patient-card-visits.png" width="49%" alt="Patient visit history">
<img src="docs/screenshots/12-patient-data.png" width="49%" alt="Patient personal data">

### Dental chart

<img src="docs/screenshots/08-dental-formula.png" width="100%" alt="Dental chart according to FDI system">

### Patient questionnaire

<img src="docs/screenshots/16-survey.png" width="49%" alt="Patient medical questionnaire">
<img src="docs/screenshots/10-snapshots.png" width="49%" alt="Patient X-rays">

### Doctor notes and examinations

<img src="docs/screenshots/09-notes.png" width="49%" alt="Doctor notes">
<img src="docs/screenshots/11-snapshot-preview.png" width="49%" alt="X-ray preview">

<img src="docs/screenshots/13-examination-sheets.png" width="49%" alt="Examination charts">
<img src="docs/screenshots/14-new-examination.png" width="49%" alt="Initial examination form">

### Profiles

<img src="docs/screenshots/15-doctor-profile.png" width="49%" alt="Doctor profile">
<img src="docs/screenshots/17-client-view.png" width="49%" alt="Patient personal cabinet">

---

## Features

| Section | Features |
|---|---|
| **Electronic medical record** | Patient registration, insurance policy/SNILS/passport, address, phone, visit history, visit status (confirmed / not confirmed / cancelled) |
| **Dental chart** | Full scheme of 32 teeth (FDI system) with statuses for each tooth: caries, filling, treatment, extraction, prosthesis, crown, cyst |
| **Schedule** | Daily, weekly and monthly schedules by doctor; check for visit overlaps and treatment duration when booking |
| **Examinations** | Four types of examination charts: "Initial examination", "Follow-up visit", "Professional cleaning", "Emergency case" |
| **Doctor notes** | Text notes with importance level, linked to patient record |
| **X-rays/Snapshots** | Upload snapshots (Multer), link to visit and tooth numbers, preview in modal window |
| **Patient questionnaire** | Medical survey: pain, sensitivity, gum bleeding, habits, allergies, anesthesia |
| **Staff management** | Administrator manages doctors and receptionists; each doctor has profile, specialty, schedule, avatar |
| **Roles and access** | Four roles with different permissions and sets of screens |

## Roles

| Role | Redirect after login | Permissions |
|---|---|---|
| `admin` | `/adminpanel/doctors.php` | Staff, patients, receptionists, delete records and snapshots, full access to medical records |
| `doctor` | `/personal/profiledoctor.php` | Own schedule, patient records, dental chart, notes, snapshots, examinations, manage records |
| `manager` | `/kalendar/kalendar.php` | Clinic schedule, patient cards |
| `client` | `/users/view.php?patientCardId=N` | Own record, visit history, questionnaire |

---

## Technologies

**Backend**

- Node.js 18+, ES Modules
- Express 4 — REST API
- Sequelize 6 + MySQL (`mysql2`)
- JWT (`jsonwebtoken`) — role-based auth, `authenticateToken` middleware
- `bcrypt` — password hashing
- `multer` — avatar and snapshot uploads
- `dayjs` — date and visit duration handling
- `express-validator`, `cors`, `dotenv`, `body-parser`

**Frontend**

- PHP (pages and partial templates via `include`)
- Bootstrap 5, Font Awesome 6, Bootstrap Icons
- Vanilla JavaScript: `fetch`, `jwt-decode`, DOM manipulation

---

## Project structure

```
DentalBook/
├── index.php                 # authentication
├── logout.php
├── css/style.css
├── js/auth.js                # JWT parsing, token from cookie
│
├── adminpanel/               # admin panel: doctors, patients, managers, navbar
├── inspection/               # examination forms: initial / repeatvisit / cleaning / danger
├── kalendar/                 # schedule: day / week / month
├── personal/                 # doctor/staff cabinet
├── users/                    # patient cabinet, card, formula, notes, snapshots, survey
│
└── backend/
    ├── index.js              # Express entry point, router mounting
    ├── package.json
    ├── admin/                # admin controller and router
    ├── doctors/              # doctor model, controller, router
    ├── patientCard/          # card, visits, teeth, notes, snapshots, examinations models
    ├── users/                # user model, auth, router
    ├── utils/                # DB connection, config, middleware
    └── uploads/              # uploaded avatars and snapshots
```

## Database schema

| Table | Purpose |
|---|---|
| `users` | User accounts: login, password hash, role, gender, avatar |
| `doctors` | Doctor profiles: full name, specialty, phone, date of birth |
| `patient_cards` | Medical records: full name, date of birth, contacts, address, policy, SNILS, passport |
| `visits` | Visits: date, time, type (`Examination` / `Treatment` / `Consultation`), doctor, status (`Not confirmed` / `Confirmed` / `Cancelled`) |
| `teeth` | Patient teeth (32 positions by FDI) |
| `tooth_statuses` | Tooth statuses (caries, filling, extraction, etc.) |
| `patient_notes` | Doctor notes with importance level |
| `snapshots` | X-rays/snapshots: file, tooth numbers, description, linked to visit |
| `examination_sheets` | Examination charts of four types |
| `medical_surveys` | Patient questionnaires |

---

## Setup

### Requirements

- Node.js 18+
- MySQL 8.0+ (compatible with MariaDB 10.6+)
- PHP 8 + web server (Apache / XAMPP / OpenServer)

### 1. Database

```sql
CREATE DATABASE dentalbook CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 2. Backend

```bash
cd backend
npm install
```

Create `backend/.env`:

```ini
HOST=127.0.0.1
PORT=3306
TABLE=dentalbook
JWT_SECRET=your_secret_key_here
```

Start:

```bash
npm run dev      # nodemon index.js
```

API will run at `http://localhost:3003`, tables are created automatically on start (`dbST.sync({ alter: true })`).

### 3. Frontend

Open the repository root as `DocumentRoot` in Apache/XAMPP and go to `http://localhost/`.

> **Note:** The API URL (`http://localhost:3003`) is hardcoded in client JavaScript. If you change the port or host, you need to update all API calls in `users/`, `adminpanel/`, `personal/`, `kalendar/`, `inspection/`.

### 4. First login

Create administrator via request:

```http
POST /api/admin/create/admin
Content-Type: application/json

{ "firstName": "...", "lastName": "...", "patronymic": "...",
  "email": "admin@clinic.ru", "password": "...", "gender": "female" }
```

Then doctors and receptionists can be added from the admin panel.

---

## API (main groups)

| Group | Methods |
|---|---|
| Authorization | `POST /api/users/login`, `GET /api/users/profile`, `GET /api/users/check/:patientCardId`, `POST /api/users/avatar/upload` |
| Patient cards | `POST /api/patient-cards/create`, `GET /api/patient-cards/get/all`, `GET /api/patient-cards/get/patient_profile/:id`, `DELETE /api/patient-cards/card/:id` |
| Visits | `POST /api/patient-cards/visit/create`, `GET /api/patient-cards/visit/all/:id`, `PUT /api/patient-cards/visit/change/:visitId`, `GET /api/patient-cards/schedule/:date`, `GET /api/patient-cards/schedule/weekly/:from/:to`, `GET /api/patient-cards/schedule/monthly/:month` |
| Teeth | `GET /api/patient-cards/teeth/get/:patientCardId`, `PUT /api/patient-cards/teeth/update/:patientCardId` |
| Notes | `POST /api/patient-cards/notes/create/:patientCardId`, `GET /api/patient-cards/notes/getall/:patientCardId` |
| Snapshots | `POST /api/patient-cards/snapshots/create`, `GET /api/patient-cards/snapshots/getall/:patientCardId` |
| Examinations | `POST /api/patient-cards/examinationsheet/create/:patientCardId`, `GET /api/patient-cards/examinationsheet/get/:patientCardId` |
| Questionnaire | `POST /api/patient-cards/survey`, `GET /api/patient-cards/survey/:patientCardId` |
| Doctors | `GET /api/doctors/profile`, `GET /api/doctors/shudle`, `GET /api/doctors/get/all`, `POST /api/doctors/avatar/upload` |
| Admin | `GET /api/admin/doctors/get`, `GET /api/admin/patients/get`, `GET /api/admin/manager/getall`, `POST /api/admin/manager/create`, `DELETE /api/admin/doctors/:id`, `DELETE /api/admin/visit/:visitId`, `DELETE /api/admin/snapshot/:id` |

---

## Implementation details

- **Frontend** — static PHP pages. There is almost no PHP logic: pages include common parts (`navbar.php`, `profile.php`) via `include`, and all data interaction happens in the browser via `fetch` to the REST API.
- **Authorization** — JWT in `Authorization: Bearer <token>` header. Token is stored in `document.cookie`, role is read from token payload; server checks permissions in `authenticateToken` middleware.
- **Passwords** — only bcrypt hashes are stored, never in plain text.
- **Schedule** — when creating a visit, the server checks for overlaps with other visits of the doctor and considers that "Treatment" takes 60 minutes while "Examination"/"Consultation" take 30 minutes.
- **Screenshots** were taken from a working application. To run without MySQL installed, a SQLite build with pre-filled demo database was used; the backend code was not changed — only the database driver was replaced.
