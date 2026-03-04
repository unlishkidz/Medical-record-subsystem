# Quick Test Reference

## Fastest Way (1 minute)

### From PowerShell:
```
cd C:\xampp\htdocs\Medical-record-subsystem
C:\xampp\php\php.exe run_tests.php
```

### Or just double-click:
👉 `run_tests.bat`

---

## What Each Test Checks

| Test | What It Does | Expected Result |
|------|-------------|-----------------|
| PHP version compatibility | Checks PHP 7.4+ | ✓ PASS |
| Database connection | Can connect to MySQL | ✓ PASS |
| Patients table exists | Table for patients | ✓ PASS |
| Medical records table exists | Table for records | ✓ PASS |
| Sample patients exist | Optional sample data | ⊘ SKIP (normal) |
| Patients API exists | api/patients.php file | ✓ PASS |
| Records API exists | api/records.php file | ✓ PASS |
| Database host configured | Config file is set | ✓ PASS |
| Database name configured | Config file is set | ✓ PASS |
| Database user configured | Config file is set | ✓ PASS |
| Index page exists | index.php file | ✓ PASS |
| App.js exists | assets/js/app.js file | ✓ PASS |
| Style.css exists | assets/css/style.css file | ✓ PASS |

---

## Exit Codes

- **0** = All tests passed ✓ (Good!)
- **1** = Some tests failed ✗ (Fix the issue)

---

## Before Running Tests

Make sure:
1. ✓ XAMPP is installed at `C:\xampp`
2. ✓ Apache is running (green in XAMPP Control Panel)
3. ✓ MySQL is running (green in XAMPP Control Panel)
4. ✓ Project is in `C:\xampp\htdocs\Medical-record-subsystem`

---

## Common Commands

```powershell
# Navigate to project
cd C:\xampp\htdocs\Medical-record-subsystem

# Run all tests
C:\xampp\php\php.exe run_tests.php

# Load sample data (optional)
C:\xampp\mysql\bin\mysql -u root patient_records_db < database.sql

# Check if MySQL is running
tasklist | findstr mysql
```

---

## Sample Test Output

```
✓ PASS: PHP version compatibility

=== UNIT TESTS ===

--- Database Connection Test ---
✓ PASS: Database connection
✓ PASS: Patients table exists
✓ PASS: Medical records table exists
⊘ SKIP: Sample patients exist (optional)

=== TEST SUMMARY ===
Passed:  12 ✓
Failed:  0 ✗
Skipped: 1 ⊘
Total:   13
```

All passing! ✓

---

## Troubleshooting

**Tests show "Connection failed"**
- Open XAMPP Control Panel
- Click "Start" for MySQL
- Wait for it to turn green
- Run tests again

**Tests won't run**
- Open PowerShell as Administrator
- Run: `Set-ExecutionPolicy -ExecutionPolicy RemoteSigned`
- Type `Y` and press Enter
- Try running tests again

**Database command not found**
- Use: `C:\xampp\mysql\bin\mysql` (full path)
- Not just: `mysql`

---

## Files Used by Tests

```
run_tests.php          ← Main test file
run_tests.bat          ← Windows batch script
config.php             ← Database config
index.php              ← Frontend
api/patients.php       ← Patient API
api/records.php        ← Records API
assets/js/app.js       ← Frontend JS
assets/css/style.css   ← Frontend CSS
```

---

For detailed info, see: `TESTING_HOW_TO.md`
