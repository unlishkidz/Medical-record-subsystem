# Medical Record System - Testing Guide

## Quick Start

### Run All Tests (Windows)
```batch
run_tests.bat
```

### Run PHP Tests Directly
```bash
# Using XAMPP PHP
C:\xampp\php\php.exe run_tests.php

# Or from Git Bash/WSL
php run_tests.php
```

## Test Structure

### Available Tests

1. **Database Connection Tests**
   - Verifies database connectivity
   - Checks if required tables exist
   - Validates sample data is loaded

2. **API Endpoint Tests**
   - Checks if all API files are present
   - Validates API structure

3. **Configuration Tests**
   - Verifies database configuration
   - Checks required constants

4. **Frontend Tests**
   - Validates HTML, CSS, and JavaScript files exist
   - Checks file integrity

## Test Results

Tests output a summary in the format:
```
=== TEST SUMMARY ===
Passed:  XX ✓
Failed:  XX ✗
Skipped: XX ⊘
Total:   XX
```

## Exit Codes

- **0** = All tests passed ✓
- **1** = One or more tests failed ✗

## Adding New Tests

To add new tests, edit `run_tests.php` and add test cases using:

```php
TestRunner::$current_test = 'Test name';
TestRunner::assert(condition, 'Error message');
// or
TestRunner::assertEquals(expected, actual, 'Error message');
// or
TestRunner::skip('Reason for skipping');
```

### Example:
```php
TestRunner::$current_test = 'User can login';
TestRunner::assert($loginSuccessful, 'Login failed');
```

## Troubleshooting

### PHP Not Found
If you get "PHP not found" error:
1. Ensure XAMPP is installed at `C:\xampp`
2. Or update the path in `run_tests.bat`

### Database Connection Failed
1. Check if MySQL is running
2. Verify `config.php` has correct database credentials
3. Ensure database and tables are created:
   ```sql
   SOURCE database.sql;
   ```

### Tests Failing
1. Run tests individually to isolate the issue
2. Check error messages in the output
3. Verify all required files exist in proper locations
4. Check file permissions

## Best Practices

1. **Isolation**: Each test should be independent
2. **Clarity**: Use descriptive test names
3. **Assertions**: Verify expected vs actual values
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
