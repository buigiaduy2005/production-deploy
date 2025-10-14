@echo off
REM ============================================
REM Fix Docker WordPress Configuration
REM ============================================

echo.
echo ============================================
echo FIXING DOCKER CONFIGURATION
echo ============================================
echo.

REM Stop containers
echo 🛑 Stopping containers...
docker-compose down

REM Rebuild containers with fixed configuration
echo 🔧 Rebuilding containers with fixed configuration...
docker-compose build --no-cache

REM Start containers
echo 🚀 Starting containers...
docker-compose up -d

REM Wait for services to be ready
echo ⏳ Waiting for services to be ready...
timeout /t 30 /nobreak >nul

echo.
echo ✅ Configuration fixed! Your WordPress site should now work at:
echo    Website: http://localhost:8080
echo    Admin:   http://localhost:8080/wp-admin
echo.

pause
