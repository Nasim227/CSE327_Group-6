# How to Merge & Run on XAMPP

If your teammate is using XAMPP, give them these instructions to run your code.

## 1. Get the Code
Download the project files or `git pull` the latest changes.

## 2. Install Libraries
Open a terminal in the project folder and run:
```bash
composer install
npm install
```

## 3. Database Setup (XAMPP)
1. Open **XAMPP Control Panel**.
2. Start **Apache** and **MySQL**.
3. Click **Admin** next to MySQL to open **phpMyAdmin**.
4. Create a new database named `cse327_app`.
5. Click **Import** and select the `nuurem.sql` file (if you are sharing the raw DB) OR just run migrations below.

## 4. Configure Environment
1. Copy `.env.example` and rename it to `.env`.
2. Open `.env` and check these lines:

```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cse327_app
DB_USERNAME=root
DB_PASSWORD=
```
*(XAMPP usually has no password for root by default. If they set one, they need to add it here).*

## 5. Update Database
Run this command to add the latest tables and columns (like the "Remember Me" fix):

```bash
php artisan migrate
```

## 6. Run the App
```bash
npm run build
php artisan serve
```

Go to `http://localhost:8000`.
