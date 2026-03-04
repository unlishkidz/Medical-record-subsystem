# Testing Guide

This directory contains all tests for the Medical Record System.

## Structure

```
tests/
├── unit/                          # Unit tests for individual components
│   ├── PatientsApiTest.php       # Tests for patients API endpoints
│   └── RecordsApiTest.php        # Tests for records API endpoints
├── integration/                   # Integration tests
│   └── DatabaseIntegrationTest.php # Tests for database operations
├── js/                            # JavaScript/Frontend tests
│   ├── app.test.js              # Tests for app.js frontend logic
│   └── setup.js                 # Jest configuration setup
├── bootstrap.php                  # PHPUnit bootstrap file
└── README.md                      # This file
```

## Running Tests

### PHP Tests (Unit + Integration)

**Prerequisites:**
- PHPUnit installed: `composer require --dev phpunit/phpunit`
- Test database configured

**Run all PHP tests:**
```bash
./vendor/bin/phpunit
```

**Run only unit tests:**
```bash
./vendor/bin/phpunit tests/unit
```

**Run only integration tests:**
```bash
./vendor/bin/phpunit tests/integration
```

**Run specific test file:**
```bash
./vendor/bin/phpunit tests/unit/PatientsApiTest.php
```

**Generate coverage report:**
```bash
./vendor/bin/phpunit --coverage-html coverage/
```

### JavaScript Tests

**Prerequisites:**
- Node.js and npm installed
- Jest installed: `npm install --save-dev jest babel-jest @babel/preset-env`

**Run all JavaScript tests:**
```bash
npm test
```

**Run tests in watch mode:**
```bash
npm test -- --watch
```

**Generate coverage report:**
```bash
npm test -- --coverage
```

**Run specific test file:**
```bash
npm test -- app.test.js
```

## Setup Instructions

### 1. Install PHP Test Dependencies

```bash
# Install Composer (if not installed)
# Then run:
composer require --dev phpunit/phpunit
```

### 2. Setup Test Database

Create a test database for isolated testing:

```sql
CREATE DATABASE patient_records_test;
USE patient_records_test;
SOURCE database.sql;
```

Update `config.php` to support test database detection, or create a `config.test.php`.

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
