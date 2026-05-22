@echo off
title JACHAmarket - Crear Super Admin
cd /d "%~dp0"

REM Buscar PHP en rutas comunes
set PHP_CMD=php

where php >nul 2>&1
if %ERRORLEVEL% NEQ 0 (
    if exist "C:\xampp\php\php.exe" (
        set PHP_CMD=C:\xampp\php\php.exe
    ) else (
        echo.
        echo [ERROR] PHP no encontrado.
        echo Instala PHP o agrega la ruta al PATH.
        echo.
        echo Rutas buscadas: php, C:\xampp\php\php.exe
        echo.
        pause
        exit /b 1
    )
)

echo.
echo ============================================
echo    JACHAmarket - Crear Super Administrador
echo ============================================
echo.
%PHP_CMD% setup-admin.php
echo.
pause
