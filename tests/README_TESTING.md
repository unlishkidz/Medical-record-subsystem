# Testing Guide - Quick Reference

For complete testing documentation, see:
- **[TESTING_HOW_TO.md](../TESTING_HOW_TO.md)** - Step-by-step guide
- **[README.md](./README.md)** - Test structure and setup
- **[QUICK_TEST_GUIDE.md](../QUICK_TEST_GUIDE.md)** - 30-second quick start

---

## 🚀 Quick Start

### Windows (Recommended)
```powershell
.\run_tests.bat
```

### PowerShell
```powershell
C:\xampp\php\php.exe run_tests.php
```

### VS Code Terminal
```powershell
Ctrl + ` (open terminal)
.\run_tests.bat
```

---

## 📋 Available Test Suites

### 1. Quick Test (Custom Tests)
Validates project setup and dependencies.

```powershell
.\run_tests.bat
# or
C:\xampp\php\php.exe run_tests.php
```

**What it checks:**
- ✓ PHP version (7.4+)
- ✓ Database connection
- ✓ Required tables exist
- ✓ API files present
- ✓ Configuration set
- ✓ Frontend files present

### 2. PHPUnit (PHP Tests)
Unit and integration testing for backend.

```bash
composer install
./vendor/bin/phpunit
./vendor/bin/phpunit tests/unit
./vendor/bin/phpunit tests/integration
```

### 3. Jest (JavaScript Tests)
Frontend logic testing.

```bash
npm install
npm test
npm test -- --coverage
```

---

## 📊 Understanding Results

```
=== TEST SUMMARY ===
Passed:  13 ✓  ← All tests passed
Failed:  0 ✗   ← No failures
Skipped: 1 ⊘   ← Optional tests skipped
Total:   14
```

**Exit Code:**
- `0` = Success ✅
- `1` = Failure ❌

---

## 🔧 Troubleshooting

### MySQL Connection Failed
1. Open XAMPP Control Panel
2. Click "Start" for MySQL
3. Run tests again

### Database Not Found
```bash
mysql -u root < database.sql
```

### PHP Not Found  
Update `run_tests.bat` XAMPP path to match your installation.

### More Help
See [TESTING_HOW_TO.md](../TESTING_HOW_TO.md) for detailed troubleshooting.

---

## 📚 Adding New Tests

### PHPUnit Test Example
File: `tests/unit/MyTest.php`
```php
<?php namespace Tests\Unit;
use PHPUnit\Framework\TestCase;

class MyTest extends TestCase {
    public function testExample() {
        $this->assertTrue(true);
    }
}
```

Run it:
```bash
./vendor/bin/phpunit tests/unit/MyTest.php
```

### Jest Test Example
File: `tests/js/my.test.js`
```javascript
describe('MyModule', () => {
    test('works', () => {
        expect(1 + 1).toBe(2);
    });
});
```

Run it:
```bash
npm test -- my.test.js
```

---

## ✅ Pre-Commit Checklist

Before committing code:
1. Run `.\run_tests.bat`
2. All tests should pass (exit code 0)
3. No errors in test output
4. Fix any failing tests before commit

---

## 📖 Documentation Links

| Document | Purpose |
|----------|---------|
| [TESTING_HOW_TO.md](../TESTING_HOW_TO.md) | Complete testing guide |
| [QUICK_TEST_GUIDE.md](../QUICK_TEST_GUIDE.md) | 30-second quick start |
| [README.md](./README.md) | Test structure details |
| [README.md](../README.md) | Main project docs |
| [phpunit.xml](../phpunit.xml) | PHPUnit config |
| [jest.config.js](../jest.config.js) | Jest config |
4. **Coverage**: Test both success and failure cases
5. **Performance**: Keep tests fast (< 1 second per test)

## Continuous Integration

To integrate tests with CI/CD:

```yaml
# Example for GitHub Actions
- name: Run Tests
  run: C:\xampp\php\php.exe run_tests.php
```

## Sample Test Output

```
=== UNIT TESTS ===

--- Database Connection Test ---
✓ PASS: Database connection
✓ PASS: Patients table exists
✓ PASS: Medical records table exists
✓ PASS: Sample patients exist

--- API Endpoint Tests ---
✓ PASS: Patients API exists
✓ PASS: Records API exists

--- Configuration Tests ---
✓ PASS: Database host configured
✓ PASS: Database name configured
✓ PASS: Database user configured

--- Frontend Tests ---
✓ PASS: Index page exists
✓ PASS: App.js exists
✓ PASS: Style.css exists

=== TEST SUMMARY ===
Passed:  13 ✓
Failed:  0 ✗
Skipped: 0 ⊘
Total:   13
```
