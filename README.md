# MediRec — Medical Record Management System
### Practical Activity Assessment 1 | BSCS 3-B

Built with: **PHP · HTML · CSS · JavaScript · MySQL**

📍 **Repository:** [Medical-record-subsystem](https://github.com/unlishkidz/Medical-record-subsystem)

---

## 📁 Project Structure

```
Medical-record-subsystem/
├── index.php                   # Main application entry point
├── config.php                  # Database connection config
├── database.sql                # MySQL schema + sample data
├── api/
│   ├── patients.php            # REST API: patients (CRUD)
│   └── records.php             # REST API: medical records (CRUD)
├── assets/
│   ├── css/
│   │   └── style.css           # Full stylesheet
│   └── js/
│       └── app.js              # All frontend logic
└── tests/                      # PHPUnit and Jest tests
    ├── unit/                   # Unit tests
    ├── integration/            # Integration tests
    └── js/                     # JavaScript tests
```

---Prerequisites
- PHP 7.4+ (8.0+ recommended)
- MySQL 5.7+ / MariaDB 10.4+
- Apache or Nginx (XAMPP / WAMP / Laragon recommended)
- For testing: Composer (for PHPUnit), Node.js (for Jest
### 1. Requirements
- PHP 8.0+
- MySQL 5.7+ / MariaDB 10+
- Apache or Nginx (XAMPP / WAMP / Laragon recommended)
Clone Repository
```bash
git clone https://github.com/unlishkidz/Medical-record-subsystem.git
cd Medical-record-subsystem
```

### 3. Database Setup
4. Configure Database
Edit `config.php`:
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');     // your MySQL username
define('DB_PASS', '');         // your MySQL password
define('DB_NAME', 'patient_records_db');
```

### 5. Deploy
Place the entire folder inside your web server root:
- **XAMPP:** `C:/xampp/htdocs/Medical-record-subsystem/`
- **WAMP:**  `C:/wamp64/www/Medical-record-subsystem/`
- **Laragon:** `C:/laragon/www/Medical-record-subsystem/`

### 6. Run Application
Open your browser:
```
http://localhost/Medicalhost');
define('DB_USER', 'root');     // your MySQL username
define('DB_PASS', '');         // your MySQL password
define('DB_NAME', 'patient_records_db');
```
🧪 Testing

For detailed testing documentation, see:
- [TESTING_HOW_TO.md](TESTING_HOW_TO.md) - Step by step guide
- [tests/README.md](tests/README.md) - Test structure and PHPUnit/Jest setup

**Quick Test (Windows):**
```powershell
.\run_tests.bat
```

**PHP Unit Tests:**
```bash
composer require --dev phpunit/phpunit
./vendor/bin/phpunit
```

**JavaScript Tests:**
```bash
npm install --save-dev jest @babel/preset-env babel-jest
npm test
```� API Documentation

### Patients API
**File:** `api/patients.php`
- `GET` - Get all patients
- `GET?id={id}` - Get specific patient with records
- `POST` - Create new patient
- `PUT?id={id}` - Update patient information
- `DELETE?id={id}` - Delete patient (cascades to records)

### Medical Records API
**File:** `api/records.php`
- `GET` - Get all medical records
- `GET?id={id}` - Get specific medical record
- `GET?patient_id={id}` - Get all records for patient
- `POST` - Create new medical record
- `PUT?id={id}` - Update medical record
- `DELETE?id={id}` - Delete medical record

---

## 👥 Team
- Denniel Josh A. Colmo
- Cian Kevin M. Villanueva
- Katrina Marie D. Degala
- Christian Leslie Banlor

**Course:** BSCS 3-B | **Framework:** Vanilla PHP + JavaScript (No Framework)

---

## 📄 License

This project is created for educational purposes as part of BSCS 3-B coursework.
- XAMPP: `C:/xampp/htdocs/patient-record-subsystem/`
- WAMP:  `C:/wamp64/www/patient-record-subsystem/`

### 5. Run
Open your browser and go to:
```
http://localhost/patient-record-subsystem/
```

---

## ✅ Features

| Feature | Status |
|---|---|
| Dashboard with stats & charts | ✅ |
| Patient list with search | ✅ |
| Add new patient | ✅ |
| Edit patient info | ✅ |
| Delete patient (cascades records) | ✅ |
| View patient detail & records | ✅ |
| Add medical record to patient | ✅ |
| Edit medical record | ✅ |
| Delete medical record | ✅ |
| Duplicate patient ID prevention | ✅ |
| Input validation (required fields) | ✅ |
| Gender distribution donut chart | ✅ |
| Toast notifications | ✅ |
| Confirm dialogs before delete | ✅ |

---

## 👥 Team
- Denniel Josh A. Colmo
- Cian Kevin M. Villanueva
- Katrina Marie D. Degala
- Christian Leslie Banlor

**Course/Section:** BSCS 3-B | **Framework:** None (Vanilla PHP + JS)
