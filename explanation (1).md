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

# Project Explanation - Teaching Guide

## 60-90 Second Presentation Script

### Opening (10 seconds)
"I'll demonstrate the authentication system I built for our CSE327 project. It uses Laravel's MVC architecture with complete PHPDoc documentation and automated tests."

### Part 1: Structure (20 seconds)
"The project follows MVC. Models like User.php represent database tables. Controllers like AuthController.php handle requests. Views like login.blade.php display HTML. Routes in web.php connect URLs to controllers."

### Part 2: Features (20 seconds)
"It has separate authentication for customers and admins. Customers log in at /login, admins at /admin/login. They use different database tables and guards, so there's complete separation. Password hashing, 'remember me', and session management are all implemented."

### Part 3: Documentation (20 seconds)
"Every class and method has PHPDoc comments. I can generate professional API documentation with one command: vendor/bin/phpdoc. Here's the PHPDOC_GUIDE explaining how it works."

### Part 4: Testing (15 seconds)
"I wrote automated tests using PHPUnit. Here's AdminTest.php. I can run php artisan test to verify everything works."

### Closing (5 seconds)
"The README has setup instructions. Everything is documented. Happy to answer questions."

## Anticipated Questions & Answers

### Q: "What's the difference between Unit tests and Feature tests?"
**A:** "Unit tests check individual functions in isolation, like testing if the User model's fullName() method combines first and last names correctly. Feature tests check entire user flows, like whether a user can successfully register, get redirected to the home page, and have their password hashed in the database."

### Q: "Why separate User and Admin?"
**A:** "Security and separation of concerns. Customers and staff have different privileges. Using separate models (User.php vs Admin.php) and guards ('web' vs 'admin') ensures admins can't accidentally use customer features and vice versa. They even use different database tables."

### Q: "What is a guard in Laravel?"
**A:** "A guard is Laravel's way of managing who is logged in. The 'web' guard tracks customer sessions, the 'admin' guard tracks staff sessions. They're independent - you can be logged in as a customer and not as admin, or vice versa."

### Q: "How does 'Remember Me' work?"
**A:** "When checked, Laravel stores a long-lived token in the remember_token column. Even if the session expires, the token allows automatic re-authentication. Without it, the session lasts 120 minutes by default."

## Key Files to Highlight

| What to Show | File to Open | Key Lines |
|--------------|--------------|-----------|
| User Model | app/Models/User.php | Lines 45-50 (password hashing) |
| Auth Controller | app/Http/Controllers/AuthController.php | Lines 95-130 (login method) |
| Admin Controller | app/Http/Controllers/AdminAuthController.php | Login with guards |
| Login View | resources/views/auth/login.blade.php | Form, CSRF, error display |
| Routes | routes/web.php | All routes |
| Database Config | config/auth.php | Guards configuration |
| Unit Test Example | tests/Unit/AdminTest.php | Test structure |
| Feature Test Example | tests/Feature/LoginTest.php | HTTP testing |