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

## Features
*   **Login** (Email & Password)
*   **Sign Up** (With validation)
*   **Remember Me** (Keeps you logged in)
*   **Logout**
*   **Secure Password Hashing**
