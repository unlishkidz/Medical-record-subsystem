@echo off
REM Simple test runner batch script for Windows
REM This script runs the PHP test suite

echo Running Medical Record System Tests...
echo.

REM Detect XAMPP installation
if exist "C:\xampp\php\php.exe" (
    "C:\xampp\php\php.exe" run_tests.php
) else if exist "C:\wamp\bin\php\*\php.exe" (
    for /d %%d in ("C:\wamp\bin\php\*") do (
        "%%d\php.exe" run_tests.php
        goto done
    )
) else (
    echo Error: PHP not found. Please ensure XAMPP or WAMP is installed.
    echo Expected path: C:\xampp\php\php.exe
    exit /b 1
)

:done
pause
