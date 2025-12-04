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

# MVC Architecture Explanation

## What is MVC?

**MVC** stands for **Model-View-Controller**. It's a design pattern that separates an application into three main components:

1. **Model (M)** - Manages data and business logic
2. **View (V)** - Displays information to the user
3. **Controller (C)** - Handles user input and coordinates between Model and View

### Restaurant Analogy

- **Model** = Kitchen (where food is prepared, data is processed)
- **View** = Menu & Plate (what customers see)
- **Controller** = Waiter (takes orders from customers, delivers to kitchen, brings food back)

## How Laravel Implements MVC

Laravel is built around the MVC pattern, but adds extra layers for flexibility:

```
User Request → Routes → Controller → Model → Database
                          ↓           ↓
                        View    ←  Data
```

### Flow Example: User Login

1. **User clicks "Login"** → Goes to URL `/login`
2. **Router** (`routes/web.php`) → Maps `/login` to `AuthController@show_login`
3. **Controller** (`AuthController.php`) → `show_login()` method runs
4. **View** (`login.blade.php`) → HTML form is displayed
5. **User submits form** → Goes to POST `/login`
6. **Controller** → `login_user()` validates and calls...
7. **Model** (`User.php`) → Checks database for email/password
8. **Controller** → Redirects to home page or shows error
9. **View** → (`welcome.blade.php` or back to `login.blade.php`)

## Models: The "M" in MVC

**Purpose**: Represent database tables and contain business logic.

**Location**: `app/Models/`

**What they do:**
- Define table structure
- Validate data
- Perform calculations
- Contain business rules (e.g., "password must be hashed")

## Views: The "V" in MVC

**Purpose**: Display HTML to the user.

**Location**: `resources/views/`

**What they do:**
- Render HTML with dynamic data
- Use Blade templating (Laravel's template engine)
- Display forms, tables, buttons, etc.

## Controllers: The "C" in MVC

**Purpose**: Handle HTTP requests and coordinate between Models and Views.

**Location**: `app/Http/Controllers/`

**What they do:**
- Receive user input (form data, URL parameters)
- Validate input
- Call Model methods to fetch/save data
- Return Views or redirect to other pages

## Benefits of MVC

1. **Separation of Concerns** - Code is organized logically
2. **Reusability** - Models can be used by multiple controllers
3. **Testability** - Each component can be tested independently
4. **Maintainability** - Easy to find and fix bugs
5. **Team Collaboration** - Different developers can work on different parts