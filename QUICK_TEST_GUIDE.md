# Quick Test Reference

⚡ **Fastest Way:** Run tests in 30 seconds or less

## Run Tests

### Option 1: Windows Batch (Recommended)
Just double-click:
```
run_tests.bat
```

### Option 2: PowerShell
```powershell
cd C:\xampp\htdocs\Medical-record-subsystem
C:\xampp\php\php.exe run_tests.php
```

### Option 3: VS Code Terminal
```
Ctrl + ` (open terminal)
.\run_tests.bat
```

---

## What Tests Check

| Test | Validates |
|------|-----------|
| PHP version | PHP 7.4+ installed |
| Database connection | Can reach MySQL database |
| Tables exist | `patients` and `medical_records` tables created |
| Sample data | Optional test data present |
| API files | `api/patients.php`, `api/records.php` exist |
| Config | Database configuration is set |
| Frontend | HTML, CSS, JavaScript files present |

---

## Understanding Results

```
✓ PASS   = Test succeeded ✅
✗ FAIL   = Test failed - needs fixing ⚠️
⊘ SKIP   = Test skipped - optional
```

### Example Output
```
=== TEST SUMMARY ===
Passed:  13 ✓
Failed:  0 ✗
Skipped: 1 ⊘
Total:   14
```

**Exit Code 0** = All tests passed ✓  
**Exit Code 1** = Some tests failed ✗

---

## Before Testing

Ensure:
1. ✓ XAMPP installed at `C:\xampp`
2. ✓ Apache running (green indicator in XAMPP panel)
3. ✓ MySQL running (green indicator in XAMPP panel)
4. ✓ Project in `C:\xampp\htdocs\Medical-record-subsystem`
5. ✓ Database `patient_records_db` created
6. ✓ `config.php` database settings are correct

---

## Common Issues & Fixes

**"Connection failed to database"**
- Open XAMPP Control Panel → Start MySQL

**"Database patient_records_db not found"**
- Run: `mysql -u root < database.sql`

**"PHP not found"**
- Update path in `run_tests.bat` to your XAMPP location

**Tests still failing?**
- See [TESTING_HOW_TO.md](TESTING_HOW_TO.md) for detailed guide
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
