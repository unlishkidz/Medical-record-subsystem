# How to Run Tests - Complete Guide

See also: [QUICK_TEST_GUIDE.md](QUICK_TEST_GUIDE.md) for a quick reference.

---

## Method 1: Simple Windows Batch (⭐ Recommended)

The easiest way to run all tests.

### Step 1: Open File Explorer
Navigate to your project folder:
```
C:\xampp\htdocs\Medical-record-subsystem
```

### Step 2: Double-Click run_tests.bat
That's it! The test results will display in a terminal window.

**Alternative:** Right-click `run_tests.bat` → Open with → Command Prompt

---

## Method 2: PowerShell Terminal

### Step 1: Open PowerShell
- Press `Win + R`
- Type `powershell`, press Enter

### Step 2: Navigate to Project
```powershell
cd C:\xampp\htdocs\Medical-record-subsystem
```

### Step 3: Run Tests
```powershell
.\run_tests.bat
```

Or run PHP directly:
```powershell
C:\xampp\php\php.exe run_tests.php
```

---

## Method 3: VS Code Terminal (Best for Developers)

### Step 1: Open VS Code
Open the project folder in Visual Studio Code

### Step 2: Open Integrated Terminal
- Menu: `Terminal` → `New Terminal`
- Or press: `Ctrl + ` (backtick key, above Tab)

### Step 3: Terminal Opens in Project Folder
You should see:
```
PS C:\xampp\htdocs\Medical-record-subsystem>
```

### Step 4: Run Tests
```powershell
.\run_tests.bat
```

---

## Reading Test Output

### Each Test Line Shows Status

```
✓ PASS: PHP version compatibility
```
✅ Test succeeded

```
✗ FAIL: Database connection
```
❌ Test failed - see error message below it

```
⊘ SKIP: Sample patients exist
```
⏭️ Test was skipped (usually optional data)

---

## Test Summary

After all tests complete, you'll see:

```
=== TEST SUMMARY ===
Passed:  13 ✓
Failed:  0 ✗
Skipped: 1 ⊘
Total:   14
```

**Exit Code 0:** All tests passed ✓  
**Exit Code 1:** Some tests failed ✗

---

## PHP Unit Tests (Advanced)

If you have PHPUnit installed, run specific test suites:

```bash
# Install PHPUnit first
composer require --dev phpunit/phpunit

# Run all PHP tests
./vendor/bin/phpunit

# Run only unit tests
./vendor/bin/phpunit tests/unit

# Run only integration tests
./vendor/bin/phpunit tests/integration

# Run with coverage report
./vendor/bin/phpunit --coverage-html coverage/
```

---

## JavaScript Tests (Advanced)

If you have Jest installed, run JavaScript tests:

```bash
# Install Jest first
npm install --save-dev jest @babel/preset-env babel-jest

# Run all JavaScript tests
npm test

# Watch mode (reruns on file changes)
npm test -- --watch

# Generate coverage report
npm test -- --coverage
```

---

## Troubleshooting

### Issue: "PHP not found"
**Cause:** PHP path is incorrect in `run_tests.bat`

**Fix:**
1. Open `run_tests.bat` in a text editor
2. Check the PHP path matches your XAMPP installation
3. If XAMPP is at `C:\xampp`, it should work as-is
4. If elsewhere, update the path

### Issue: "MySQL connection failed"
**Cause:** MySQL is not running

**Fix:**
1. Open XAMPP Control Panel
2. Click "Start" for MySQL
3. Wait for it to turn green
4. Run tests again

### Issue: "Database patient_records_db does not exist"
**Cause:** Database not created with sample data

**Fix:**
```bash
# Create database and tables
mysql -u root < database.sql
```

Or using phpMyAdmin:
1. Go to `http://localhost/phpmyadmin`
2. Create new database: `patient_records_db`
3. Import file: `database.sql`

### Issue: Tests pass intermittently
**Cause:** Database not properly configured

**Fix:**
1. Verify `config.php` settings match your MySQL setup
2. Ensure database credentials are correct
3. Check that all tables were created

### Issue: "Permission denied"
**Cause:** Run tests from PowerShell as Administrator

**Fix:**
1. Right-click PowerShell → "Run as administrator"
2. Run: `Set-ExecutionPolicy -ExecutionPolicy RemoteSigned -Scope CurrentUser`
3. Confirm with `Y`
4. Run tests again

---

## Best Practices

✅ **DO:**
- Run tests before committing code
- Keep tests database separate from production
- Run tests regularly during development
- Use watch mode for JavaScript tests during development

❌ **DON'T:**
- Run tests as root/administrator unless necessary
- Modify tests database structure manually
- Rely on test results with MySQL stopped
- Ignore test failures

---

## Additional Resources

- [QUICK_TEST_GUIDE.md](QUICK_TEST_GUIDE.md) - Quick reference
- [README.md](README.md) - Main documentation
- [tests/README.md](tests/README.md) - Test structure

### Failing Test
```
✗ FAIL: Sample patients exist - Sample data loaded: 0 patients
```
Something is wrong ✗

### Skipped Test
```
⊘ SKIP: Sample patients exist (optional) - No sample data loaded
```
Test was skipped on purpose ⊘

---

## Common Issues & Solutions

### Issue: "PHP command not found"
**Solution:** XAMPP not installed or not in PATH
- Ensure XAMPP is installed at `C:\xampp`
- Use full path: `C:\xampp\php\php.exe run_tests.php`

### Issue: "Database connection failed"
**Solution:** MySQL is not running
1. Open XAMPP Control Panel
2. Click "Start" for Apache and MySQL
3. Wait for them to turn green
4. Try running tests again

### Issue: "Sample patients exist" is skipped
**Solution:** This is optional - sample data not loaded (normal)
- To load sample data, see "Load Sample Data" section below

---

## Load Sample Data (Optional)

### Option 1: Using phpMyAdmin (Easiest)
1. Open browser: http://localhost/phpmyadmin
2. On the left, find database `patient_records_db`
3. Click on it
4. Click the "Import" tab at the top
5. Click "Choose File"
6. Select `database.sql` from the project folder
7. Click "Go" or "Import"
8. Done! Sample data is loaded

### Option 2: Using Command Line
1. Open PowerShell
2. Navigate to project:
   ```powershell
   cd C:\xampp\htdocs\Medical-record-subsystem
   ```
3. Run:
   ```powershell
   C:\xampp\mysql\bin\mysql -u root patient_records_db < database.sql
   ```

---

## Step-by-Step Example

Let's say you want to run tests now:

### 1. Open PowerShell
   - Right-click on Desktop
   - Select "Open Terminal here" or "Open PowerShell window here"

### 2. Navigate to the project
   ```powershell
   cd C:\xampp\htdocs\Medical-record-subsystem
   ```

### 3. Run the tests
   ```powershell
   C:\xampp\php\php.exe run_tests.php
   ```

### 4. Expected output will look like:
   ```
   ✓ PASS: PHP version compatibility

   === UNIT TESTS ===

   --- Database Connection Test ---
   ✓ PASS: Database connection
   ✓ PASS: Patients table exists
   ✓ PASS: Medical records table exists
   ⊘ SKIP: Sample patients exist (optional)

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
   Passed:  12 ✓
   Failed:  0 ✗
   Skipped: 1 ⊘
   Total:   13
   ```

### 5. All tests passed! ✓

---

## Running Individual Tests

To see just specific tests, you can edit `run_tests.php` and comment out sections you don't need.

Or create a custom test file for specific functionality.

---

## Automated Testing (Every Time You Start Working)

### Create a Shortcut
1. Right-click on Desktop
2. New > Shortcut
3. For location, enter:
   ```
   C:\xampp\php\php.exe C:\xampp\htdocs\Medical-record-subsystem\run_tests.php
   ```
4. Name it: "Run Tests"
5. Click Finish

Now you can just double-click the shortcut to run tests anytime!

---

## Tips

✓ Run tests after making code changes
✓ Check test results before deploying
✓ If tests fail, fix the code before committing
✓ Keep the test terminal open to track progress
✓ Run tests frequently during development

---

## Need Help?

If tests are still failing:
1. Check the error message
2. Look at the specific test that's failing
3. Verify all required files exist
4. Ensure MySQL is running
5. Check `config.php` has correct database credentials
