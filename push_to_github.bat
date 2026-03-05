@echo off
cd /d "%~dp0"

REM Force push to GitHub
git push -u origin main --force

pause
