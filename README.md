# Laravel Authentication System

Simple login and signup system for our CSE327 project.

## Dependencies
*   PHP 8.2+
*   Composer
*   MySQL (XAMPP / Laragon)
*   Node.js & NPM

## How to Run
1.  **Install**:
    ```bash
    composer install
    npm install
    ```
2.  **Setup Database**:
    *   Create a database named `cse327_app`.
    *   Copy `.env.example` to `.env` and set your DB name/password.
    *   Run `php artisan migrate`.
3.  **Start**:
    ```bash
    npm run build
    php artisan serve
    ```

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

