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

# Changes Between Group Project and Personal Repository

## Repository Information

**Group Project (Original)**: `CSE327_Group-6` - Branch: `Sadman`
**Personal Repository**: `CSE327_Sadman_Personal` - Branches: `main` and `explain/2025-12-03-2327`

**Purpose**: This document explains all changes made when creating the personal repository from the group project.

---

## Summary of Changes

### What Stayed the Same ✓
- Core functionality (login, register, logout, admin authentication)
- Database schema (migrations unchanged)
- UI design and styling (Tailwind CSS, same look and feel)
- Routing structure
- Authentication guards (web and admin)
- All existing features work identically

### What Was Added ✅

1. **Comprehensive PHPDoc Comments**
   - Admin.php: Class and property-level documentation
   - AuthController.php: Method documentation
   - AdminAuthController.php: Method documentation
   - User.php: Already had good documentation
   - AuthManager.php: Already had good documentation

2. **Unit Tests**
   - `tests/Unit/AdminTest.php` - Tests Admin model functionality

3. **Generated API Documentation**
   - `docs/api/` folder with complete Doctum-generated documentation
   - 18 classes documented
   - Interactive HTML documentation

4. **Teaching/Learning Files**
   - `PHPDOC_GUIDE.md` - How to use and generate PHPDoc
   - `EXPLANATION_STRUCTURE.md` - Complete Laravel folder structure guide
   - `MVC_EXPLANATION.md` - MVC architecture explained
   - `EXPLANATION.md` - Teaching guide with 60-90 second demo script

5. **Line-by-Line Teaching Comments** (explain branch only)
   - AuthController.php: 260+ lines of beginner-friendly comments
   - AdminAuthController.php: 228+ lines of comments
   - routes/web.php: Complete routing tutorial in comments
   - login.blade.php: 350+ lines explaining HTML, Blade, forms, JavaScript

6. **Documentation Tools**
   - `doctum.phar` - Documentation generator
   - `doctum_config.php` - Configuration for generating docs

---

## File-by-File Comparison

### Backend Files

#### 1. `app/Models/Admin.php`

**Group Project Version (BEFORE):**
```php
<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $guard = 'admin';

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }
}
```

**Personal Repository Version (AFTER - main branch):**
```php
<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Admin Model
 * 
 * Represents administrative staff accounts in the system.
 * Completely separate from regular User accounts with its own authentication guard.
 * 
 * @property int $id Unique identifier for the admin
 * @property string $name Full name of the admin
 * @property string $email Email address (unique, used for login)
 * @property string $password Hashed password
 * @property string|null $remember_token Token for "remember me" functionality
 * @property \Carbon\Carbon $created_at Timestamp when admin was created
 * @property \Carbon\Carbon $updated_at Timestamp when admin was last updated
 * 
 * @package App\Models
 */
class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The authentication guard this model uses
     * 
     * @var string
     */
    protected $guard = 'admin';

    /**
     * Mass-assignable attributes
     * These can be set via Admin::create() or $admin->fill()
     * 
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * Attributes hidden from JSON serialization
     * Prevents passwords and tokens from being exposed in API responses
     * 
     * @var array<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast
     * Laravel automatically hashes the password when set
     * 
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }
}
```

**Changes Made:**
- ✅ Added comprehensive class-level PHPDoc with `@property` tags documenting all model attributes
- ✅ Added property-level documentation for `$guard`, `$fillable`, and `$hidden`
- ✅ Added method documentation for `casts()`
- ✅ Functionality remains 100% identical

---

#### 2. `app/Http/Controllers/AuthController.php`

**Group Project Version (BEFORE):**
Had basic PHPDoc but minimal documentation.

**Personal Repository Version (AFTER):**
- ✅ Enhanced class-level documentation explaining the controller's purpose
- ✅ Improved method docblocks with detailed `@param` and `@return` descriptions
- ✅ **explain branch**: Added 260+ lines of teaching comments explaining every line of code

**Changes Made:**
- Functionality: 0 changes - works exactly the same
- Documentation: Significantly enhanced
- Teaching comments (explain branch only): Explains what, how, and why for every line

---

#### 3. `app/Http/Controllers/AdminAuthController.php`

**Group Project Version (BEFORE):**
Had basic PHPDoc.

**Personal Repository Version (AFTER):**
- ✅ Enhanced class and method documentation
- ✅ **explain branch**: Added 228+ lines of teaching comments

**Changes Made:**
- Functionality: 0 changes
- Documentation: Significantly enhanced

---

### Frontend Files

#### 4. `resources/views/auth/login.blade.php`

**Group Project Version (BEFORE):**
Minimal or no comments in the Blade template.

**Personal Repository Version (explain branch):**
- ✅ Added 350+ lines of teaching comments
- ✅ Explains every HTML element
- ✅ Explains Blade directives (`@extends`, `@section`, `{{ }}`, `@csrf`, etc.)
- ✅ Explains form submission flow
- ✅ Explains Alpine.js integration for password toggle
- ✅ Explains CSRF protection

**Changes Made:**
- UI/functionality: 0 changes - looks and works exactly the same
- Comments: Comprehensive beginner-friendly explanations added

---

### Routing

#### 5. `routes/web.php`

**Group Project Version (BEFORE):**
Basic routing with minimal comments.

**Personal Repository Version (explain branch):**
- ✅ Added comprehensive routing tutorial in comments
- ✅ Explains middleware (`auth`, `guest`, `auth:admin`, `guest:admin`)
- ✅ Explains guards
- ✅ Explains route naming
- ⚠️ One minor change: Simplified routing structure slightly (but all routes still work the same)

**Changes Made:**
- Routes: All routes identical and functional
- Comments: Complete routing education added

---

### New Files Created

#### 6. `tests/Unit/AdminTest.php` ✨ NEW

**What it does:**
Tests the Admin model following PHPUnit conventions:
- Tests model creation
- Tests fillable attributes
- Tests hidden attributes
- Tests guard configuration

**Format:**
- Docblocks above each test
- Uses `new Admin()` instantiation
- Uses `$this->assertEquals()` assertions

---

#### 7. `PHPDOC_GUIDE.md` ✨ NEW

**What it contains:**
- Explanation of PHPDoc and its purpose
- How to write PHPDoc comments
- How to run Doctum to generate documentation
- Examples from the codebase
- Benefits of documentation

---

#### 8. `EXPLANATION_STRUCTURE.md` ✨ NEW

**What it contains:**
- Detailed explanation of every Laravel folder
- Answers: What is it? What goes in it? How does this project use it? MVC role?
- Covers: `/app`, `/resources`, `/routes`, `/database`, `/tests`, `/config`, etc.

---

#### 9. `MVC_EXPLANATION.md` ✨ NEW

**What it contains:**
- What MVC means
- How Laravel implements MVC
- Restaurant analogy for easy understanding
- User login flow diagram
- Where business logic belongs
- Which files represent M, V, and C in this project

---

#### 10. `EXPLANATION.md` ✨ NEW

**What it contains:**
- File-by-file teaching guide
- Key lines to highlight for each file
- **60-90 second demo script for presentation**
- Anticipated instructor questions & answers
- Presentation tips

---

#### 11. `docs/api/` ✨ NEW

**What it contains:**
- Generated API documentation using Doctum
- `index.html` - Main documentation page
- Complete documentation for 18 classes
- Interactive navigation and search

---

#### 12. `doctum_config.php` ✨ NEW

**What it is:**
Configuration file for Doctum documentation generator.

---

## Testing & Verification

### Tests That Run Successfully

```bash
# Run all tests
php artisan test

# Run unit tests only
php artisan test tests/Unit/

# Run specific test
php artisan test tests/Unit/AdminTest.php
```

**Expected Output:**
```
Tests:    4 passed
Duration: < 1 second
```

### Functional Verification

✅ **User Registration**
- Navigate to `/register`
- Fill out form (first name, last name, email, password)
- Submit
- User is registered and logged in automatically
- Redirected to home page

✅ **User Login**
- Navigate to `/login`
- Enter email and password
- Check "Remember Me" (optional)
- Submit
- User is logged in
- Redirected to home page or intended page

✅ **User Logout**
- Click logout button
- User is logged out
- Session destroyed
- Redirected to login page

✅ **Admin Login**
- Navigate to `/admin/login`
- Enter admin email and password
- Submit
- Admin is logged in
- Redirected to admin dashboard

✅ **Admin Registration**
- Navigate to `/admin/register`
- Fill out form
- Submit
- Admin account created and logged in
- Redirected to admin dashboard

✅ **Admin Logout**
- Click logout in admin dashboard
- Admin is logged out
- Redirected to admin login

### UI Verification

✅ **Login Page**
- Logo displays correctly
- Form fields are styled with Tailwind CSS
- Password toggle (eye icon) works
- Error messages display in red box
- "Remember Me" checkbox is functional
- "Sign up" link navigates to register page

✅ **Registration Page**
- Same styling as login
- Validation errors display correctly
- Password confirmation works

✅ **Admin Login Page**
- Separate page at `/admin/login`
- Same styling consistency
- Works independently from user login

✅ **Admin Dashboard**
- Displays admin's name
- Logout button works
- Protected by `auth:admin` middleware

---

## Key Differences Summary

| Aspect | Group Project | Personal Repository |
|--------|---------------|---------------------|
| **Core Code** | Functional | Identical - works the same |
| **PHPDoc** | Basic | Comprehensive with @property, @param, @return |
| **Unit Tests** | ❌ None | ✅ AdminTest.php |
| **Generated Docs** | ❌ None | ✅ Complete Doctum documentation |
| **Teaching Guides** | ❌ None | ✅ 4 comprehensive guides |
| **Line-by-Line Comments** | ❌ None | ✅ 1000+ lines (explain branch) |
| **Functionality** | ✅ Works | ✅ Works identically |
| **UI** | ✅ Looks good | ✅ Looks identical |

---

## Original CSE327 Project Explanation (Before Changes)

### What the Project Was

The CSE327 Group Project was a **Laravel-based authentication system** created as a group assignment. It included:

**Core Features:**
1. User authentication (login, register, logout)
2. Admin authentication (separate admin panel)
3. Session management
4. "Remember Me" functionality
5. Clean, modern UI using Tailwind CSS

**Technical Stack:**
- Laravel 11.x (PHP framework)
- MySQL database (via `user` and `admins` tables)
- Tailwind CSS (styling)
- Alpine.js (minimal JavaScript for interactions)

**Architecture:**
- Custom authentication using `AuthManager` service
- Separate guards for users (`web`) and admins (`admin`)
- MVC pattern (Models, Views, Controllers)
- Blade templating engine for views

### What Was Missing

Despite being functional, the group project lacked:
- ❌ Professional documentation (PHPDoc)
- ❌ Unit tests
- ❌ Teaching materials for presentation
- ❌ Beginner-friendly explanations
- ❌ Generated API documentation

### Why Personal Repository Was Created

The personal repository was created to:
1. **Learn deeply by refactoring**: Understand every line by documenting it
2. **Create teaching materials**: Make the code explainable to instructors
3. **Add professional touches**: PHPDoc, tests, generated documentation
4. **Separate from group work**: Avoid affecting the group project
5. **Demonstrate understanding**: Show mastery through documentation

---

## Verification Checklist

### ✅ Code Works Identically
- [x] User can register
- [x] User can login
- [x] User can logout
- [x] Admin can login at /admin/login
- [x] Admin can register at /admin/register
- [x] Admin can access dashboard
- [x] Admin can logout
- [x] Sessions work correctly
- [x] Remember Me functionality works
- [x] Guards prevent unauthorized access

### ✅ UI Looks Identical
- [x] Login page matches group project
- [x] Registration page matches group project
- [x] Admin login page matches group project
- [x] Admin dashboard matches group project
- [x] Tailwind CSS styling identical
- [x] Password toggle icon works
- [x] Form validation displays correctly

### ✅ Tests Pass
- [x] `php artisan test` runs successfully
- [x] AdminTest.php passes (4/4 tests)
- [x] No PHP errors
- [x] No database errors

### ✅ Documentation Complete
- [x] PHPDoc in all controllers and models
- [x] Teaching guides created
- [x] API documentation generated
- [x] Line-by-line comments added (explain branch)

---

## How to Verify Everything Works

### Step 1: Clone and Setup
```bash
git clone https://github.com/Szaman07/CSE327_Sadman_Personal.git
cd CSE327_Sadman_Personal
composer install
cp .env.example .env
php artisan key:generate
```

### Step 2: Configure Database
Edit `.env` file:
```
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### Step 3: Run Migrations
```bash
php artisan migrate
```

### Step 4: Run Tests
```bash
php artisan test
```

Expected: All tests pass ✅

### Step 5: Start Server
```bash
php artisan serve
```

### Step 6: Test Functionality
1. Visit `http://localhost:8000/register` - Register a user
2. Login at `http://localhost:8000/login`
3. Logout
4. Visit `http://localhost:8000/admin/register` - Register an admin
5. Login at `http://localhost:8000/admin/login`

### Step 7: View Documentation
Open `docs/api/index.html` in browser to see generated API documentation.

---

## Conclusion

The personal repository is a **fully documented, tested, and explained version** of the group project that:
- ✅ Functions identically to the original
- ✅ Includes comprehensive documentation
- ✅ Has beginner-friendly teaching materials
- ✅ Passes all tests
- ✅ Looks identical (same UI)
- ✅ Is ready for presentation

**No functionality was broken or changed** - only documentation, tests, and teaching materials were added.

---

## Live Session Additions (December 4, 2025)

The following features were added during the live presentation preparation session:

### User Status Management
| File | Type | Purpose |
|------|------|---------|
| `app/Http/Middleware/CheckUserStatus.php` | NEW | Security middleware that blocks inactive users |
| `database/migrations/add_status_to_user_table.php` | NEW | Adds 'status' column to user table |
| `app/Models/User.php` | MODIFIED | Added 'status' to $fillable |
| `bootstrap/app.php` | MODIFIED | Registered 'check-status' middleware alias |

### Product Inventory System
| File | Type | Purpose |
|------|------|---------|
| `app/Models/Product.php` | NEW | Product model with CRUD capabilities |
| `app/Http/Controllers/ProductController.php` | NEW | Handles Add/Edit/Delete products |
| `database/migrations/create_products_table.php` | NEW | Creates products table |

### Admin Dashboard Enhancements
| File | Type | Purpose |
|------|------|---------|
| `app/Http/Controllers/DashboardController.php` | MODIFIED | Added toggleUserStatus(), real product data |
| `resources/views/dashboard/admin.blade.php` | MODIFIED | User status toggle UI, Product CRUD UI |

### How to Demonstrate

1. **User Status Toggle:**
   - Login as admin at `/admin/login`
   - Click "Deactivate" on any user
   - Try to login as that user → Blocked!
   - Click "Activate" to restore access

2. **Product Management:**
   - Click "Add Product" → Fill form → Submit
   - Click "Edit" on any product → Modify values → Save
   - Click "Delete" → Confirm → Product removed

3. **Security Check:**
   - Login as a regular user
   - Have admin deactivate their account
   - User's next page load will log them out automatically

