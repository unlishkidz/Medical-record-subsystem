@echo off
REM Load sample data into database
REM This script requires MySQL to be running

echo.
echo ========================================
echo Medical Record System - Database Setup
echo ========================================
echo.

REM Check if MySQL is available
where mysql >nul 2>nul
if %ERRORLEVEL% neq 0 (
    echo MySQL command not found in PATH.
    echo.
    echo Option 1: Use phpMyAdmin
    echo   1. Open: http://localhost/phpmyadmin
    echo   2. Create database: patient_records_db
    echo   3. Click "Import" tab
    echo   4. Select database.sql file
    echo   5. Click "Go"
    echo.
    echo Option 2: Use MySQL CLI
    echo   1. Open Command Prompt or PowerShell
    echo   2. Navigate to XAMPP directory: cd C:\xampp\mysql\bin
    echo   3. Run: mysql -u root -p patient_records_db less than database.sql
    echo.
    pause
    exit /b 1
)

REM Try to load the database
echo Loading sample data from database.sql...
mysql -u root patient_records_db less than database.sql
if %ERRORLEVEL% equ 0 (
    echo.
    echo SUCCESS: Database loaded!
    echo.
) else (
    echo.
    echo ERROR: Failed to load database.
    echo Please ensure:
    echo - MySQL is running
    echo - Database "patient_records_db" exists
    echo - You have proper permissions
    echo.
)

pause
