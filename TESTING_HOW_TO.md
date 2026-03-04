# How to Run Tests - Step by Step Guide

## Method 1: Simple Windows Batch (Recommended for Windows Users)

### Step 1: Open Command Prompt or PowerShell
1. Press `Win + R` to open Run dialog
2. Type `cmd` or `powershell` and press Enter
3. you should see a terminal window

### Step 2: Navigate to Project Folder
```powershell
cd C:\xampp\htdocs\Medical-record-subsystem
```

You should see:
```
PS C:\xampp\htdocs\Medical-record-subsystem>
```

### Step 3: Run the Tests
```powershell
.\run_tests.bat
```

Or just double-click `run_tests.bat` in the file explorer

### Step 4: View Results
The test results will appear in the terminal showing:
```
✓ PASS: Test name
✗ FAIL: Test name
⊘ SKIP: Test name
```

And a summary at the end:
```
=== TEST SUMMARY ===
Passed:  12 ✓
Failed:  0 ✗
Skipped: 1 ⊘
Total:   13
```

---

## Method 2: Using PHP Directly (Advanced)

### Step 1: Open PowerShell or Command Prompt
Press `Win + R`, type `powershell`, press Enter

### Step 2: Navigate to Project
```powershell
cd C:\xampp\htdocs\Medical-record-subsystem
```

### Step 3: Run Tests with XAMPP PHP
```powershell
C:\xampp\php\php.exe run_tests.php
```

### Step 4: Read the Output
Wait for all tests to complete and review the results

---

## Method 3: Using VS Code Terminal

### Step 1: Open VS Code
Open the project folder in VS Code

### Step 2: Open Terminal
- Click menu: `Terminal` > `New Terminal`
- Or press `Ctrl + backtick` (the key above Tab)

### Step 3: You're Already in Project Folder
The terminal should show:
```
PS C:\xampp\htdocs\Medical-record-subsystem>
```

### Step 4: Run Tests
```powershell
C:\xampp\php\php.exe run_tests.php
```

Or:
```powershell
.\run_tests.bat
```

---

## Understanding Test Output

### Passing Test
```
✓ PASS: PHP version compatibility
```
Everything is working ✓

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
