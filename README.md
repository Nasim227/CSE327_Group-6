# Laravel Authentication System

Simple login and signup system for our CSE327 project.

## Dependencies
- PHP 8.2+
- Composer
- MySQL (XAMPP / Laragon)
- Node.js & NPM

## How to Run

### Step 1: Install Dependencies
```bash
composer install
npm install
```

### Step 2: Environment Setup
```bash
# Copy the example environment file
copy .env.example .env

# Generate application key
php artisan key:generate
```

### Step 3: Database Setup

**Option A: Using phpMyAdmin (XAMPP)**
1. Start XAMPP and ensure MySQL is running
2. Open http://localhost/phpmyadmin
3. Click "New" on the left sidebar
4. Enter database name: `cse327_app`
5. Click "Create"

**Option B: Using MySQL Command Line**
```bash
mysql -u root -p
CREATE DATABASE cse327_app;
exit;
```

### Step 4: Configure Database Connection
Edit the `.env` file with your database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cse327_app
DB_USERNAME=root
DB_PASSWORD=
```
> **Note**: Leave `DB_PASSWORD` empty if you haven't set a MySQL password (default for XAMPP).

### Step 5: Run Database Migrations
```bash
php artisan migrate
```
This creates all the necessary tables (`user`, `admins`, `products`, etc.).

### Step 6: Build & Start
```bash
npm run build
php artisan serve
```
Open http://localhost:8000 in your browser.

---

## Testing

We use **PHPUnit** for all testing.

### Run All Tests
```bash
php artisan test
```

### White Box Tests (Unit)
```bash
php artisan test --testsuite=Unit
```

### Black Box Tests (Feature)
```bash
php artisan test --testsuite=Feature
```

---

## Features
- **Login** (Email & Password)
- **Sign Up** (With validation)
- **Remember Me** (Persistent sessions)
- **Logout**
- **Secure Password Hashing**

## Admin Features
- **Separate Login**: `/admin/login`
- **Admin Dashboard**: `/admin/dashboard`
- **Staff Registration**: `/admin/register`
- **User Management**: Activate/Deactivate users
- **Product Management**: Add/Edit/Delete products

---

## Troubleshooting

**"SQLSTATE[HY000] [1045] Access denied"**
- Check your `DB_USERNAME` and `DB_PASSWORD` in `.env`
- Run `php artisan config:clear`

**"Base table or view not found"**
- Run `php artisan migrate`

**Port 8000 already in use**
```bash
php artisan serve --port=8001
```
