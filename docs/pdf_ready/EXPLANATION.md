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

This document explains each file I modified, why I modified it, and how to present it during your demo.

---

## Files Modified/Created

### 1. `PHPDOC_GUIDE.md`

**What it is**: A guide for generating professional API documentation from code comments.

**Why I created it**: 
- Shows you understand documentation best practices
- Demonstrates knowledge of industry-standard tools
- Gives you something concrete to show during presentation

**How to explain it**:
"PHPDoc is like adding instructions to your code that can automatically generate a beautiful documentation website. Every professional PHP project uses this. I've written detailed comments above each function explaining what it does, what parameters it takes, and what it returns. Then, with one command, I can generate an entire documentation site."

**Key lines to highlight**:
1. **Line 19-27**: Example PHPDoc comment showing `@param` and `@return` tags
2. **Line 70-72**: Command to generate documentation: `vendor/bin/phpdoc -d app -t docs/api`
3. **Line 88-91**: Benefits section

---

### 2. `EXPLANATION_STRUCTURE.md`

**What it is**: Complete explanation of every folder in a Laravel project.

**Why I created it**:
- Proves you understand the Laravel framework structure
- Makes it easy to answer instructor questions like "What's in the /app folder?"
- Shows you can explain technical concepts clearly

**How to explain it**:
"Laravel has a specific folder structure. Each folder has a purpose. For example, `/app/Models` contains files that represent database tables, while `/resources/views` contains the HTML templates users see. This document explains every folder and how our authentication project uses it."

**Key sections to highlight**:
1. Lines 7-22 (`/app` explanation): Shows you understand the application core
2. Lines 131-145 (`/database/migrations`): Explains how database schema is managed
3. Lines 147-155 (`/tests`): Shows automated testing structure

---

### 3. `tests/Unit/AdminTest.php`

**What it is**: Unit test for the Admin model following your exact conventions.

**Why I created it**:
- Demonstrates Test-Driven Development (TDD)
- Shows you can write automated tests
- Follows the specific docblock format from your requirements

**How to explain it**:
"This test verifies that the Admin model works correctly. I create a new Admin instance, set properties, and use `assertEquals` to confirm the values are set properly. Each test has a docblock explaining what it tests."

**Key lines to highlight**:
1. **Lines 10-13**: Docblock format (`Test the create method of the Admin model`)
2. **Line 16**: Creating instance: `new Admin()`
3. **Line 21**: Assertion: `$this->assertEquals('Test Admin', $admin->name)`
4. **Line 44**: Testing security: Ensures password is hidden from JSON responses

**Run command to show**:
```bash
php artisan test tests/Unit/AdminTest.php
```

---

### 4. `app/Models/Admin.php`

**What I changed**: Added comprehensive PHPDoc comments.

**Why**:
- Makes the code professional and self-documenting
- Shows understanding of class properties and methods
- Enables PHPDocumentor to generate beautiful API docs

**How to explain it**:
"The Admin model represents staff accounts. I've added documentation explaining each property - what it is, what type it is, and what it's used for. The `@property` tags tell other developers (and tools) exactly what data this model contains."

**Key lines to highlight**:
1. **Lines 9-22**: Class-level docblock with all `@property` tags
2. **Lines 30-36**: Explanation of `$guard` property
3. **Lines 38-44**: Explanation of `$fillable` (mass-assignable attributes)
4. **Lines 52-60**: Explanation of why password is "casted" to hashed

---

### 5. `app/Http/Controllers/AuthController.php`

**What I changed**: Enhanced method documentation.

**Why**:
- Clarifies what each controller method does
- Explains the flow of user authentication
- Makes code easier to maintain and understand

**How to explain it**:
"The AuthController handles customer login and registration. Each method has a clear docblock. For example, `login_user()` validates email and password, then authenticates the user. If 'remember me' is checked, it creates a persistent login token."

**Key lines to highlight**:
1. **Lines 10-21**: Class-level docblock explaining controller purpose
2. **Lines 30-37**: `login_user()` docblock showing it validates and authenticates
3. **Lines 70-76**: `register_user()` docblock explaining automatic login after registration

---

### 6. `MVC_EXPLANATION.md`

**What it is**: Complete explanation of the MVC architecture pattern.

**Why I created it**:
- Demonstrates deep understanding of software design patterns
- Explains how Laravel implements MVC specifically
- Provides concrete examples from this project

**How to explain it**:
"MVC separates code into Model (data), View (display), and Controller (logic). In our project, the User model represents customer data, the login view shows the HTML form, and the AuthController coordinates between them. When a user logs in, the controller validates their input, asks the model to check the database, and returns the appropriate view."

**Key sections to highlight**:
1. **Lines 6-13**: Restaurant analogy (easy to understand)
2. **Lines 21-36**: Login flow diagram
3. **Lines 146-165**: User registration flow (step-by-step)
4. **Lines 167-179**: Admin vs User separation (shows good architecture)
5. **Lines 217-223**: Demonstrating MVC to instructor (practice this!)

---

## 60-90 Second Presentation Script

**Opening (10 seconds)**:
"I'll demonstrate the authentication system I built for our CSE327 project. It uses Laravel's MVC architecture with complete PHPDoc documentation and automated tests."

**Part 1: Structure (20 seconds)**:
"The project follows MVC. Models like User.php represent database tables. Controllers like AuthController.php handle requests. Views like login.blade.php display HTML. Routes in web.php connect URLs to controllers."

**Part 2: Features (20 seconds)**:
"It has separate authentication for customers and admins. Customers log in at /login, admins at /admin/login. They use different database tables and guards, so there's complete separation. Password hashing, 'remember me', and session management are all implemented."

**Part 3: Documentation (20 seconds)**:
"Every class and method has PHPDoc comments. I can generate professional API documentation with one command: `vendor/bin/phpdoc`. Here's the PHPDOC_GUIDE explaining how it works."

**Part 4: Testing (15 seconds)**:
"I wrote automated tests using PHPUnit. Here's AdminTest.php following the conventions from class. I can run `php artisan test` to verify everything works."

**Closing (5 seconds)**:
"The README has setup instructions. Everything is documented in EXPLANATION_STRUCTURE.md and MVC_EXPLANATION.md. Happy to answer questions."

---

## Anticipated Instructor Questions & Answers

**Q: "What's the difference between Unit tests and Feature tests?"**
A: "Unit tests check individual functions in isolation, like testing if the User model's fullName() method combines first and last names correctly. Feature tests check entire user flows, like whether a user can successfully register, get redirected to the home page, and have their password hashed in the database."

**Q: "Why separate User and Admin?"**
A: "Security and separation of concerns. Customers and staff have different privileges. Using separate models (`User.php` vs `Admin.php`) and guards ('web' vs 'admin') ensures admins can't accidentally use customer features and vice versa. They even use different database tables."

**Q: "What is a guard in Laravel?"**
A: "A guard is Laravel's way of managing who is logged in. The 'web' guard tracks customer sessions, the 'admin' guard tracks staff sessions. They're independent - you can be logged in as a customer and not as admin, or vice versa."

**Q: "How does 'Remember Me' work?"**
A: "When checked, Laravel stores a long-lived token in the `remember_token` column. Even if the session expires, the token allows automatic re-authentication. Without it, the session lasts 120 minutes by default."

**Q: "What's the purpose of AuthManager.php?"**
A: "It's a service class containing reusable authentication logic. Instead of duplicating code between User and Admin controllers, I put shared methods like `authenticate()` and `rememberUser()` in AuthManager. This follows the Don't Repeat Yourself (DRY) principle."

---

## Tips for Presenting

1. **Have the repo open** in VS Code or your editor
2. **Run tests live**: `php artisan test` to show they pass
3. **Show one PHPDoc example** in code, then show this guide
4. **Navigate the folder structure** while explaining EXPLANATION_STRUCTURE.md
5. **Have localhost:8000 running** to show the login page live
6. **Practice the 60-second script** at least 3 times before presenting

---

## New Admin Dashboard Features (Live Session Additions)

### 1. User Status Management

**Files Created:**
- `app/Http/Middleware/CheckUserStatus.php` - Security middleware
- `database/migrations/add_status_to_user_table.php` - Database change

**What it does:**
- Adds 'active'/'inactive' status to user accounts
- Admins can toggle user status from the dashboard
- Inactive users are immediately logged out and blocked

**How to explain it:**
"This is a security feature. If we need to disable a user account (fraud, abuse, etc.), we toggle their status to 'inactive'. The `CheckUserStatus` middleware runs on every request and logs them out immediately."

**Code flow:**
1. Admin clicks "Deactivate" button
2. `DashboardController::toggleUserStatus()` flips the status
3. Next time user makes a request, `CheckUserStatus` middleware catches them
4. User is logged out and shown an error message

---

### 2. Product Inventory Management

**Files Created:**
- `app/Models/Product.php` - Product model
- `app/Http/Controllers/ProductController.php` - CRUD operations
- `database/migrations/create_products_table.php` - Database table

**What it does:**
- Full CRUD (Create, Read, Update, Delete) for products
- Admin can add new products via modal
- Admin can edit price, stock, and status
- Admin can delete products

**How to explain it:**
"This is a complete inventory management system. The `ProductController` handles all operations. Each method validates input, performs the database operation, and returns feedback. We use Laravel's Route Model Binding so we don't have to manually find products by ID."

---

### 3. Dashboard Controller Changes

**File Modified:** `app/Http/Controllers/DashboardController.php`

**New Method:** `toggleUserStatus(User $user)`
- Uses Route Model Binding to auto-load the user
- Flips status between 'active' and 'inactive'
- Returns success message

**Modified Method:** `adminDashboard()`
- Now fetches real products: `Product::all()`
- Passes products to the view for display

---

Good luck with your presentation!

