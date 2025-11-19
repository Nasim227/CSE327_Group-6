# Laravel Authentication System - README

## Project Overview
Laravel-based authentication system with Login and Signup functionality, featuring comprehensive testing and adherence to strict coding standards.

## Tech Stack
- **Backend**: PHP 8.3, Laravel 11
- **Database**: MySQL
- **Frontend**: HTML, CSS (Tailwind), Blade Templates
- **Testing**: PHPUnit, Codeception

## Prerequisites
1. **PHP** 8.3+ installed
2. **Composer** installed
3. **MySQL** server running (via Laragon or standalone)
4. **Node.js** & **npm** (for asset compilation)

## Installation & Setup

### 1. Clone Repository
```bash
git clone <repository-url>
cd temp_app
```

### 2. Install Dependencies
```bash
composer install
npm install
```

### 3. Environment Configuration
Copy `.env.example` to `.env`:
```bash
copy .env.example .env
```

Edit `.env` and configure database:
```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cse327_app
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Database Setup
Import the provided SQL dump:
```bash
# Using MySQL CLI
mysql -u root -p cse327_app < ../nuurem.sql

# Or via Laragon/PHPMyAdmin
# Import nuurem.sql manually
```

Run migrations (for testing):
```bash
php artisan migrate
```

### 5. Generate Application Key
```bash
php artisan key:generate
```

### 6. Compile Frontend Assets
```bash
npm run dev
```

## Running the Application

### Start Development Server
```bash
php artisan serve
```

Visit: `http://127.0.0.1:8000`

### Available Routes
- **Home**: `/`
- **Login**: `/login`
- **Register**: `/register`
- **Logout**: `/logout` (POST)

## Testing

### PHPUnit Tests (27 tests)
Run all tests:
```bash
php vendor/bin/phpunit
```

Run with detailed output:
```bash
php vendor/bin/phpunit --testdox
```

Run specific test suite:
```bash
# Unit tests
php vendor/bin/phpunit tests/Unit

# Feature tests
php vendor/bin/phpunit tests/Feature
```

### Test Coverage
- **Unit Tests**: User model, AuthManager service
- **Feature Tests**: Login/Signup flows (success & failure scenarios)
- **27 tests, 64 assertions - ALL PASSING ✓**

## Architecture

### MVC Structure
```
app/
├── Http/Controllers/
│   └── AuthController.php      # Authentication logic
├── Models/
│   └── User.php               # User model
└── Services/
    └── AuthManager.php        # Auth service layer
```

### Coding Standards
- **Variables**: `camelCase`
- **Methods**: `snake_case`
- **Classes**: `PascalCase`
- **Documentation**: PHPDoc (APigen compatible)

### Class Diagram Implementation
- **User**: `register()`, `login()`, `logout()`, `updateProfile()`
- **AuthManager**: `authenticate()`, `rememberUser()`, `logoutUser()`

## Functional Requirements

### Registration (Sign Up)
✅ Creates account with hashed password  
✅ Auto-login after registration  
✅ Validates: unique email, password strength  
✅ Shows inline errors for invalid data  

### Login (Authentication)
✅ Authenticates with email/password  
✅ "Remember Me" for persistent sessions  
✅ Shows generic error for invalid credentials  
✅ Redirects to home on success  

## Documentation Generation
Generate PHPDoc documentation:
```bash
# Install APigen
composer require --dev apigen/apigen

# Generate docs
vendor/bin/apigen generate
```

## Troubleshooting

### Issue: "php: command not found"
**Solution**: Use full path to PHP:
```bash
D:\softwares\laragon\bin\php\php-8.3.26-Win32-vs16-x64\php.exe artisan serve
```

### Issue: Tests failing with "no such table: user"
**Solution**: Run migrations for test database:
```bash
php artisan migrate --env=testing
```

### Issue: Logo not showing
**Solution**: Hard refresh browser cache (Ctrl + F5)

## Contributing
This branch is for **Authentication** features only. Other features (Products, Cart, Orders) are handled by separate team members.

### Branch Mergeability
- All authentication logic is isolated
- No hard dependencies on other features
- Database schema follows provided design
- Tests ensure stability during integration

## License
CSE327 Course Project - Group 6
