@echo off
setlocal enabledelayedexpansion

echo SINERGHI Environment Switcher
echo ============================
echo.

if "%1"=="" (
    echo Usage: switch-env [local^|prod]
    echo.
    echo Options:
    echo   local    Switch to local development environment (port 8080)
    echo   prod     Switch to production environment
    echo.
    goto :eof
)

if "%1"=="local" (
    echo Switching to local development environment...
    if exist .env.local (
        copy /Y .env.local .env
        echo Environment switched to LOCAL successfully.
    ) else (
        echo ERROR: .env.local file not found.
        echo Please create a .env.local file first.
    )
) else if "%1"=="prod" (
    echo Switching to production environment...
    if exist .env.prod (
        copy /Y .env.prod .env
        echo Environment switched to PRODUCTION successfully.
    ) else (
        echo ERROR: .env.prod file not found.
        echo Please create a .env.prod file first.
    )
) else (
    echo Invalid environment specified: %1
    echo Use 'local' or 'prod'
)

echo.
echo Don't forget to restart Apache after switching environments.
echo.
