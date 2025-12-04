# Laravel Authentication System

Simple login and signup system for our CSE327 project.

## Dependencies
*   PHP 8.2+
*   Composer
*   MySQL (XAMPP / Laragon)
*   Node.js & NPM

## Quick Start

### 1. Install Dependencies
```bash
composer install
npm install
```

### 2. Environment Setup
```bash
# Copy environment template
copy .env.example .env

# Generate application key
php artisan key:generate
```

### 3. Database Setup (IMPORTANT!)

**Step 3a: Configure .env File**

Open `.env` and set your database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cse327_app        # Change to your database name
DB_USERNAME=root              # Change if needed
DB_PASSWORD=                  # Add password if you have one
```

**Step 3b: Create Database**

Choose ONE method:

**Option A - Using phpMyAdmin:**
1. Open http://localhost/phpmyadmin
2. Click "New" in the left sidebar
3. Database name: `cse327_app` (or whatever you put in `.env`)
4. Collation: `utf8mb4_general_ci`
5. Click "Create"

**Option B - Using MySQL Command Line:**
```bash
mysql -u root -p
CREATE DATABASE cse327_app;
exit;
```

**Step 3c: Run Migrations** (Creates all tables automatically)
```bash
php artisan migrate
```

**What this does:**
- Creates `user` table with `remember_token` column
- Creates `admins` table
- Creates all other required tables
- Sets up proper indexes and foreign keys

**Expected Output:**
```
Migration table created successfully.
Migrating: 2025_11_19_170953_create_user_table
Migrated:  2025_11_19_170953_create_user_table (XX ms)
Migrating: 2025_12_03_222000_add_remember_token_to_user_table
Migrated:  2025_12_03_222000_add_remember_token_to_user_table (XX ms)
Migrating: 2025_12_03_230000_create_admins_table
Migrated:  2025_12_03_230000_create_admins_table (XX ms)
```

> **Note:** Do NOT import `nuurem.sql` manually! Migrations handle everything automatically and work with any database name.

### 4. Build & Start
```bash
# Build frontend assets
npm run build

# Start development server
php artisan serve
```

**Open your browser:** http://localhost:8000

---

## Troubleshooting

### "Access denied for user 'root'"
**Fix:** Update `.env` with correct username/password, then run:
```bash
php artisan config:clear
```

### "Base table or view not found: 'user'"
**Fix:** You forgot to run migrations:
```bash
php artisan migrate
```

### "Remember Me doesn't work"
**Fix:** Missing `remember_token` column. Reset migrations:
```bash
php artisan migrate:fresh
```

### Port 8000 already in use
**Fix:** Use a different port:
```bash
php artisan serve --port=8001
```

---

## Testing

We use **PHPUnit** for all testing. Tests are categorized as follows:

### 1. White Box Tests (Unit Tests)
*   **Location**: `tests/Unit`
*   **Purpose**: Test internal logic, classes, and methods (e.g., `User` model, `AuthManager`).
*   **Command**:
    ```bash
    php artisan test --testsuite=Unit
    ```

### 2. Black Box Tests (Feature Tests)
*   **Location**: `tests/Feature`
*   **Purpose**: Test external behavior, HTTP requests, and page responses (e.g., Login page loads, Registration works).
*   **Command**:
    ```bash
    php artisan test --testsuite=Feature
    ```

### Run All Tests
```bash
php artisan test
```

## Features
*   **Login** (Email & Password)
*   **Sign Up** (With validation)
*   **Remember Me** (Keeps you logged in)
*   **Logout**
*   **Secure Password Hashing**

## Admin Features
*   **Separate Login**: `/admin/login`
*   **Admin Dashboard**: `/admin/dashboard`
*   **Staff Registration**: `/admin/register`
