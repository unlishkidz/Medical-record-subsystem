# MediRec — Patient Record Management System
### Practical Activity Assessment 1 | BSCS 3-B

Built with: **PHP · HTML · CSS · JavaScript · MySQL**

---

## 📁 Project Structure

```
patient-record-subsystem/
├── index.php                   # Main application entry point
├── config.php                  # Database connection config
├── database.sql                # MySQL schema + sample data
├── api/
│   ├── patients.php            # REST API: patients (CRUD)
│   └── records.php             # REST API: medical records (CRUD)
└── assets/
    ├── css/
    │   └── style.css           # Full stylesheet
    └── js/
        └── app.js              # All frontend logic
```

---

## ⚙️ Setup Instructions

### 1. Requirements
- PHP 8.0+
- MySQL 5.7+ / MariaDB 10+
- Apache or Nginx (XAMPP / WAMP / Laragon recommended)

### 2. Database Setup
Open **phpMyAdmin** (or MySQL CLI) and run:
```sql
SOURCE /path/to/patient-record-subsystem/database.sql;
```
This creates the database, tables, and loads 5 sample patients with 6 medical records.

### 3. Configure Database
Edit `config.php`:
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');     // your MySQL username
define('DB_PASS', '');         // your MySQL password
define('DB_NAME', 'patient_records_db');
```

### 4. Deploy
Place the entire folder inside your web server root:
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
