# Testing Guide

This directory contains unit tests, integration tests, and frontend tests for the Medical Record System.

---

## 📁 Test Structure

```
tests/
├── unit/                              # Unit tests for API endpoints
│   ├── PatientsApiTest.php           # Tests for patients API
│   ├── RecordsApiTest.php            # Tests for records API
│   └── PatientValidationTest.php     # Tests for input validation
├── integration/                       # Integration tests
│   ├── DatabaseConnectionTest.php    # Database connectivity tests
│   └── DatabaseIntegrationTest.php   # Database operation tests
├── js/                                # JavaScript/Frontend tests
│   ├── app.test.js                  # Tests for app.js logic
│   ├── setup.js                     # Jest configuration
│   └── __mocks__/                   # Mock dependencies
├── bootstrap.php                      # PHPUnit bootstrap configuration
└── README.md                          # This file
```

---

## 🚀 Running Tests

### Quick Start (Windows)
```powershell
.\run_tests.bat
```

### PHP Unit + Integration Tests

**Install PHPUnit:**
```bash
composer require --dev phpunit/phpunit
```

**Run All Tests:**
```bash
./vendor/bin/phpunit
```

**Run Specific Test Suite:**
```bash
# Unit tests only
./vendor/bin/phpunit tests/unit

# Integration tests only
./vendor/bin/phpunit tests/integration

# Specific test file
./vendor/bin/phpunit tests/unit/PatientsApiTest.php
```

**Generate Code Coverage:**
```bash
./vendor/bin/phpunit --coverage-html coverage/
```
Open `coverage/index.html` to view coverage report.

---

### JavaScript Tests

**Install Jest:**
```bash
npm install --save-dev jest @babel/preset-env babel-jest
```

**Run All Tests:**
```bash
npm test
```

**Run in Watch Mode:**
```bash
npm test -- --watch
```

**Generate Coverage Report:**
```bash
npm test -- --coverage
```

---

## 🧪 What Each Test Does

### Unit Tests

#### PatientValidationTest.php
- Validates required fields (ID, name, DOB, contact)
- Checks email format validation
- Ensures phone number format compliance
- Tests gender field constraints

#### PatientsApiTest.php
- Tests GET all patients
- Tests GET specific patient
- Tests POST (create) patient
- Tests PUT (update) patient
- Tests DELETE patient

#### RecordsApiTest.php
- Tests create medical record
- Tests update medical record
- Tests delete medical record
- Tests retrieve records for patient

### Integration Tests

#### DatabaseConnectionTest.php
- Verifies database connectivity
- Tests table existence
- Validates table structure
- Checks for sample data

#### DatabaseIntegrationTest.php
- Tests full CRUD operations
- Validates cascading deletes
- Tests data persistence
- Verifies data integrity

### Frontend Tests

#### app.test.js
- Tests UI element rendering
- Tests form submission
- Tests data validation on client-side
- Tests API communication

---

## ✅ Expected Test Results

### PHP Tests (PHPUnit)
```
PHPUnit 9.5.x by Sebastian Bergmann

✓ Database Connection Tests
✓ Patient API Tests
✓ Records API Tests
✓ Validation Tests

Time: 1.23 seconds
Tests: 18, Assertions: 42, Passed ✓
```

### JavaScript Tests (Jest)
```
PASS js/app.test.js
  ✓ renders patient list
  ✓ adds new patient
  ✓ updates patient
  ✓ deletes patient

Test Suites: 1 passed, 1 total
Tests: 4 passed, 4 total
Snapshots: 0 total
Time: 0.456s
```

---

## 🔧 Setup for Local Testing

### 1. Create Test Database
```sql
CREATE DATABASE patient_records_test;
USE patient_records_test;
SOURCE database.sql;
```

### 2. Configure Test Environment
Create `config.test.php` or update `config.php` to detect test environment:
```php
$is_test = getenv('APP_ENV') === 'test';
$db_name = $is_test ? 'patient_records_test' : 'patient_records_db';
```

### 3. Update Bootstrap
Edit `tests/bootstrap.php` to set test database:
```php
putenv('APP_ENV=test');
require_once 'config.php';
```

---

## 📋 Adding New Tests

### PHPUnit Example
```php
<?php
namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class MyNewTest extends TestCase
{
    public function testSomething()
    {
        $this->assertTrue(true);
    }
    
    public function testWithAssertion()
    {
        $expected = 10;
        $actual = 5 + 5;
        $this->assertEquals($expected, $actual);
    }
}
```

### Jest Example
```javascript
describe('MyComponent', () => {
    test('renders without crashing', () => {
        const element = document.createElement('div');
        expect(element).toBeTruthy();
    });
    
    test('handles click event', () => {
        const handleClick = jest.fn();
        handleClick();
        expect(handleClick).toHaveBeenCalled();
    });
});
```

---

## 🐛 Debugging Tests

### Run Single Test
```bash
./vendor/bin/phpunit tests/unit/PatientsApiTest.php::testGetPatients
```

### Enable Debug Output
```bash
./vendor/bin/phpunit --debug tests/
```

### Check Log Files
Tests typically log to:
- `tests/logs/` (if created)
- System temp directory
- Or stdout if no log configured

---

## ⚠️ Common Issues & Solutions

### "Class not found"
**Issue:** Test can't find API classes

**Fix:** Check `tests/bootstrap.php` includes correct paths

### "Connection refused"
**Issue:** Database not running

**Fix:** Start MySQL in XAMPP Control Panel

### "Access denied for user"
**Issue:** Wrong database credentials

**Fix:** Update credentials in config and bootstrap files

### "Table doesn't exist"
**Issue:** Database not initialized with schema

**Fix:** Run `mysql -u root < database.sql`

---

## 📊 Coverage Goals

Target these coverage metrics:
- **Line Coverage:** > 80%
- **Branch Coverage:** > 75%
- **Function Coverage:** > 85%

View coverage report:
```bash
./vendor/bin/phpunit --coverage-html coverage/
open coverage/index.html
```

---

## 🔗 Related Documentation

- [QUICK_TEST_GUIDE.md](../QUICK_TEST_GUIDE.md) - Quick reference
- [TESTING_HOW_TO.md](../TESTING_HOW_TO.md) - Detailed guide
- [README.md](../README.md) - Main project documentation
- [phpunit.xml](../phpunit.xml) - PHPUnit configuration
- [jest.config.js](../jest.config.js) - Jest configuration

### 3. Install JavaScript Test Dependencies

```bash
npm init -y
npm install --save-dev jest babel-jest @babel/preset-env
```

### 4. Create `.babelrc` for JavaScript tests

```json
{
  "presets": [["@babel/preset-env", {
    "targets": {
      "node": "current"
    }
  }]]
}
```

## Test Implementation Checklist

### PHP Tests
- [ ] Patient CRUD operations
- [ ] Medical record CRUD operations
- [ ] Database constraints and relationships
- [ ] Input validation
- [ ] Error handling
- [ ] Authentication/Authorization (if implemented)

### JavaScript Tests
- [ ] State management
- [ ] Component rendering
- [ ] User interactions
- [ ] Form validation
- [ ] API communication
- [ ] Search and filter functionality
- [ ] Error handling and notifications

## Best Practices

1. **Isolation**: Each test should be independent and not rely on other tests
2. **Clarity**: Test names should clearly describe what is being tested
3. **Coverage**: Aim for at least 80% code coverage
4. **Mocking**: Mock external dependencies (API calls, database)
5. **Cleanup**: Clean up test data after each test runs
6. **Performance**: Keep tests fast (typically < 1 second per test)

## Continuous Integration

To integrate tests with CI/CD pipelines, use:

```yaml
# Example GitHub Actions workflow
- name: Run PHP Tests
  run: ./vendor/bin/phpunit

- name: Run JavaScript Tests
  run: npm test
```
