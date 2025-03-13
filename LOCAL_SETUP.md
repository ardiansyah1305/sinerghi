# SINERGHI - Local Development Setup

This guide explains how to run the SINERGHI application locally without requiring SSO authentication.

## Overview

For local development purposes, the SSO functionality has been temporarily disabled and replaced with a regular username/password login system. This allows developers to test and develop the application without needing access to the SSO server.

## Setup Instructions

1. **Configure Apache to use port 8080**
   - The application is configured to run on port 8080
   - Apache's `httpd.conf` file should already have `Listen 8080` configured

2. **Set up the local environment**
   - Copy the `.env.local` file to `.env`:
     ```
     copy .env.local .env
     ```
   - Or use the provided script:
     ```
     switch-env.bat local
     ```

3. **Start Apache and MySQL**
   - Use XAMPP Control Panel to start Apache and MySQL services

4. **Access the application**
   - Open your browser and navigate to: `http://localhost:8080`
   - You will be presented with the regular login form instead of SSO

## Local Login Credentials

For local development, the authentication system has been simplified:

- **Username**: Use any username that exists in your database (username_ldap field)
- **Password**: Use either `password123` or `admin123`

## Switching Back to SSO

When you need to switch back to using SSO authentication:

1. Edit the `app/Controllers/AuthController.php` file to uncomment the SSO code and comment out the local login code
2. Or create a backup of the modified AuthController and restore the original when needed

## Files Modified for Local Development

1. `app/Controllers/AuthController.php` - Added regular login method and disabled SSO
2. `app/Views/auth/regular_login.php` - Added a regular login form
3. `.env.local` - Contains local environment configuration
4. `.htaccess` - Ensures proper URL routing

## Important Notes

- This setup is for **development purposes only** and should not be used in production
- The local login system uses simplified authentication and is not secure for production use
- All SSO-related code has been commented out rather than deleted to make it easy to restore

## Troubleshooting

If you encounter issues:

1. **Database Connection Problems**
   - Verify that MySQL is running
   - Check the database credentials in your `.env` file

2. **Login Issues**
   - Ensure the user exists in your database
   - Check that you're using one of the development passwords: `password123` or `admin123`

3. **Apache Port Conflicts**
   - If another service is using port 8080, modify the port in:
     - Apache's `httpd.conf` file
     - `.env.local` file (app.baseURL, SSO_URL, SSO_IP_LOCAL, SERVER_HOST)
