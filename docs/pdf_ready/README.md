<div style="text-align: right; color: #718096; font-family: sans-serif; font-size: 0.85em; border-bottom: 2px solid #e2e8f0; padding-bottom: 10px; margin-bottom: 30px;">
    <span>CSE327 Project Documentation</span> &bull; <span>Group 6 Refactor</span>
</div>

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap');

body {
    font-family: 'Inter', sans-serif;
    line-height: 1.6;
    color: #2d3748;
    max-width: 850px;
    margin: 0 auto;
    padding: 40px;
    background-color: white;
}

/* Headings */
h1 { font-size: 2.5em; color: #1a202c; border-bottom: 3px solid #3182ce; padding-bottom: 0.3em; margin-top: 1em; }
h2 { font-size: 1.75em; color: #2c5282; margin-top: 2em; border-bottom: 1px solid #e2e8f0; }
h3 { color: #2b6cb0; margin-top: 1.5em; }

/* Code Blocks */
pre {
    background-color: #f7fafc;
    border: 1px solid #cbd5e0;
    border-radius: 8px;
    padding: 1.5em;
    font-family: 'JetBrains Mono', monospace;
    font-size: 0.9em;
    overflow-x: auto;
    page-break-inside: avoid;
}
code {
    font-family: 'JetBrains Mono', monospace;
    background-color: #edf2f7;
    padding: 0.2em 0.4em;
    border-radius: 4px;
    font-size: 0.9em;
    color: #c53030;
}

/* Tables and Blockquotes */
table { border-collapse: collapse; width: 100%; margin: 2em 0; font-size: 0.9em; page-break-inside: avoid; }
th { background-color: #2d3748; color: white; padding: 12px; text-align: left; }
td { border-bottom: 1px solid #e2e8f0; padding: 12px; }
tr:nth-child(even) { background-color: #f7fafc; }

blockquote {
    border-left: 4px solid #3182ce;
    background-color: #ebf8ff;
    margin: 1.5em 0;
    padding: 1em;
    color: #2c5282;
    page-break-inside: avoid;
}

/* Print Tweaks */
@media print {
    body { padding: 0; max-width: 100%; }
    h1 { page-break-before: always; }
    h1:first-of-type { page-break-before: auto; }
}
</style>

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

