<?php

// ==============================================================================
// NAMESPACE DECLARATION
// ==============================================================================
// 
// Think of a namespace as a "folder" for organizing PHP classes
// This prevents naming conflicts if two different libraries have a class with the same name
// 
// Example: App\Http\Controllers\AuthController is the FULL name of this class
// Like how "John Smith from New York" is different from "John Smith from California"
namespace App\Http\Controllers;

// ==============================================================================
// IMPORTING CLASSES (use statements)
// ==============================================================================
//
// These are like "shortcuts" to classes we'll use in this file
// Instead of typing the full path every time, we can just use the class name

use Illuminate\Http\Request;           // Handles incoming HTTP requests (form submissions, URL parameters, etc.)
use Illuminate\Support\Facades\Auth;   // Laravel's authentication system (login/logout functionality)
use App\Models\User;                   // The User model (represents a row in the 'user' database table)
use App\Services\AuthManager;          // Our custom service for handling authentication logic

/**
 * ==============================================================================
 * AUTHENTICATION CONTROLLER
 * ==============================================================================
 * 
 * PURPOSE:
 * This controller handles all authentication for CUSTOMERS/USERS (not admins)
 * 
 * WHAT IT DOES:
 * - Shows the login form (GET /login)
 * - Processes login submissions (POST /login)
 * - Shows the registration form (GET /register)
 * - Processes registration submissions (POST /register)
 * - Logs users out (POST /logout)
 * 
 * WHY WE SEPARATE USER AND ADMIN AUTH:
 * Users and admins have different:
 * 1. Database tables ('user' vs 'admins')
 * 2. Permissions (customers can shop, admins can manage)
 * 3. Login pages (/login vs /admin/login)
 * 
 * This separation prevents security issues like customers accessing admin features
 * 
 * @package App\Http\Controllers
 */
class AuthController extends Controller
{
    /**
     * ==========================================================================
     * SHOW LOGIN PAGE
     * ==========================================================================
     * 
     * WHAT THIS DOES:
     * When a user visits /login, this method runs and shows them the login form
     * 
     * HOW IT WORKS:
     * 1. User types example.com/login in their browser
     * 2. Laravel router sees this URL and calls this method
     * 3. This method returns the 'auth.login' view (resources/views/auth/login.blade.php)
     * 4. Browser displays the HTML login form
     * 
     * ROUTE THAT CALLS THIS:
     * Route::get('/login', [AuthController::class, 'show_login'])->name('login');
     * 
     * @return \Illuminate\View\View Returns the login form view
     */
    public function show_login()
    {
        // view('auth.login') tells Laravel:
        // "Find the file at resources/views/auth/login.blade.php and render it as HTML"
        return view('auth.login');
    }

    /**
     * ==========================================================================
     * PROCESS USER LOGIN
     * ==========================================================================
     * 
     * WHAT THIS DOES:
     * When a user submits the login form, this method validates their credentials
     * and logs them in if correct
     * 
     * HOW IT WORKS (Step-by-step):
     * 1. User fills out login form (email + password) and clicks "Login"
     * 2. Form data is sent as a POST request to /login
     * 3. Laravel calls this method with the Request object containing form data
     * 4. We validate the inputs (email must be valid, password must exist)
     * 5. We create an AuthManager to check if credentials are correct
     * 6. If correct:
     *    - Regenerate session (security: prevents session fixation attacks)
     *    - If "remember me" was checked, create a persistent login token
     *    - Redirect to home page
     * 7. If incorrect:
     *    - Send user back to login page with an error message
     *    - Keep their email filled in (so they don't have to type it again)
     * 
     * SECURITY FEATURES:
     * - Session regeneration prevents session hijacking
     * - Password is never stored in plain text (hashed in database)
     * - Failed logins show generic error (doesn't reveal if email exists)
     * 
     * @param Request $request The HTTP request containing form data
     *                          Contains: ['Email' => 'user@example.com', 'password' => 'secret123', 'remember' => true/false]
     * @return \Illuminate\Http\RedirectResponse Redirects user to home or back to login
     */
    public function login_user(Request $request)
    {
        // =======================================================================
        // STEP 1: VALIDATE THE INPUT
        // =======================================================================
        //
        // $request->validate() checks if the submitted data meets our rules
        // If validation fails, Laravel automatically sends user back with error messages
        //
        // VALIDATION RULES:
        // - 'Email' field is required (can't be empty)
        // - 'Email' must be a valid email format (has @ symbol, domain, etc.)
        // - 'password' is required (can't be empty)
       //
        // WHY VALIDATE:
        // - Prevents empty submissions
        // - Prevents SQL injection
        // - Ensures data is in expected format
        //
        // WHAT HAPPENS IF VALIDATION FAILS:
        // - User is sent back to login page
        // - Error messages are displayed (e.g., "The Email field is required")
        // - Their previous input is remembered (except password for security)
        $credentials = $request->validate([
            'Email' => ['required', 'email'],      // Must be present AND valid email format
            'password' => ['required'],            // Must be present (no min length check here)
        ]);

        // =======================================================================
        // STEP 2: CREATE AUTHENTICATION MANAGER
        // =======================================================================
        //
        // AuthManager is our custom service class that handles authentication logic
        // We use a separate service to keep the controller clean (Separation of Concerns)
        //
        // WHY USE A SERVICE:
        // - Reusability: Other controllers can use AuthManager too
        // - Testability: Easier to write unit tests for isolated logic
        // - Cleaner code: Controller focuses on HTTP, AuthManager focuses on auth logic
        $authManager = new AuthManager();
        
        // =======================================================================
        // STEP 3: ATTEMPT AUTHENTICATION
        // =======================================================================
        //
        // $authManager->authenticate() checks if email and password are correct
        //
        // WHAT IT DOES INTERNALLY:
        // 1. Looks up user in database by email
        // 2. Compares submitted password (hashed) with stored password hash
        // 3. Returns true if they match, false if they don't
        //
        // WHY WE DON'T DO Auth::attempt() DIRECTLY:
        // - AuthManager encapsulates the logic
        // - Easier to modify authentication behavior in one place
        // - Can add custom logic (logging, rate limiting, etc.) in the service
        if ($authManager->authenticate($credentials['Email'], $credentials['password'])) {
            // ===================================================================
            // AUTHENTICATION SUCCESSFUL
            // ===================================================================

            // STEP 3a: Regenerate Session ID
            //
            // WHY:
            // Prevents "session fixation" attacks where an attacker tricks
            // a user into using a known session ID
            //
            // HOW IT WORKS:
            // - Old session ID: abc123
            // - After regenerate: xyz789
            // - All session data is preserved, just the ID changes
            // - Old session ID is invalidated
            $request->session()->regenerate();

            // STEP 3b: Check if "Remember Me" was selected
            //
            // $request->has('remember') checks if the checkbox was checked
            // In HTML: <input type="checkbox" name="remember">
            //
            // If checked, the form sends: remember=on
            // If unchecked, 'remember' is not sent at all
            if ($request->has('remember')) {
                // Create a "remember token" in the database
                //
                // WHAT THIS DOES:
                // - Generates a random token (e.g., "a8f3h2k9...")
                // - Stores it in the 'remember_token' column of the user's row
                // - Sets a cookie in the browser with this token
                //
                // HOW IT WORKS NEXT TIME:
                // 1. User closes browser and reopens it
                // 2. Laravel checks for remember_token cookie
                // 3. If found, automatically logs user in
                // 4. Session is recreated without requiring password
                //
                // Auth::id() returns the currently logged-in user's ID
                $authManager->rememberUser(Auth::id());
            }

            // STEP 3c: Redirect to Home
            //
            // redirect()->intended() is smart:
            // - If user was trying to access a protected page (e.g., /profile)
            //   but wasn't logged in, they were redirected to /login
            // - After logging in, ->intended() sends them to /profile (their intended destination)
            // - If they came to /login directly, sends them to route('home')
            //
            // route('home') generates the URL for the route named 'home'
            // In routes/web.php: Route::get('/', ...)->name('home');
            return redirect()->intended(route('home'));
        }

        // =======================================================================
        // AUTHENTICATION FAILED
        // =======================================================================
        //
        // If we reach this point, the email/password combination was wrong
        //
        // back() sends user back to the previous page (the login form)
        //
        // withErrors() adds error messages to the session
        // These will be displayed in the view using @if ($errors->any())
        //
        // onlyInput('Email') tells Laravel:
        // - Remember the Email field value (so user doesn't have to retype it)
        // - Do NOT remember the password field (security: never show passwords)
        //
        // SECURITY NOTE:
        // The error message is generic: "credentials do not match"
        // We don't say "email not found" or "wrong password"
        // This prevents attackers from figuring out which emails exist in our system
        return back()->withErrors([
            'Email' => 'The provided credentials do not match our records.',
        ])->onlyInput('Email');
    }

    /**
     * ==========================================================================
     * SHOW REGISTRATION PAGE
     * ==========================================================================
     * 
     * WHAT THIS DOES:
     * Displays the registration form where new users can create an account
     * 
     * HOW IT WORKS:
     * 1. User visits /register
     * 2. This method runs
     * 3. Returns the registration form view
     * 
     * @return \Illuminate\View\View Returns the registration form view
     */
    public function show_register()
    {
        // view('auth.register') renders resources/views/auth/register.blade.php
        // The form will have fields for: first_name, last_name, email, password, password_confirmation
        return view('auth.register');
    }

    /**
     * ==========================================================================
     * PROCESS USER REGISTRATION
     * ==========================================================================
     * 
     * WHAT THIS DOES:
     * Creates a new user account and automatically logs them in
     * 
     * HOW IT WORKS:
     * 1. User fills out registration form and submits
     * 2. Validate all inputs (name, email, password)
     * 3. Create new user in database with hashed password
     * 4. Automatically log them in with "remember me" enabled
     * 5. Redirect to home page
     * 
     * SECURITY FEATURES:
     * - Email must be unique (can't register with existing email)
     * - Password must be at least 8 characters
     * - Password confirmation must match (prevents typos)
     * - Password is hashed before storing (never stored in plain text)
     * 
     * @param Request $request HTTP request containing:
     *                         - First_name: User's first name
     *                         - Last_name: User's last name
     *                         - Email: User's email address
     *                         - password: User's chosen password
     *                         - password_confirmation: Password typed again for verification
     * @return \Illuminate\Http\RedirectResponse Redirects to home page
     */
    public function register_user(Request $request)
    {
        // =======================================================================
        // STEP 1: VALIDATE REGISTRATION DATA
        // =======================================================================
        //
        // Much more strict validation than login because we're creating a new account
        //
        // VALIDATION RULES:
        // 
        // First_name:
        // - 'required': Can't be empty
        // - 'string': Must be text (not a number)
        // - 'max:255': Maximum 255 characters (prevents database overflow)
        //
        // Last_name:
        // - Same rules as First_name
        //
        // Email:
        // - 'required': Can't be empty
        // - 'string': Must be text
        // - 'email': Must be valid email format (has @, domain, etc.)
        // - 'max:255': Maximum length
        // - 'unique:user,Email': IMPORTANT! Checks 'user' table's 'Email' column
        //                        If email already exists, validation fails
        //                        Error: "The Email has already been taken."
        //
        // password:
        // - 'required': Can't be empty
        // - 'string': Must be text
        // - 'min:8': Must be at least 8 characters (security: prevents weak passwords like "123")
        // - 'confirmed': Must match password_confirmation field
        //                Laravel automatically checks if password === password_confirmation
        //
        // SECURITY WHY:
        // - Prevents duplicate accounts
        // - Enforces minimum password strength
        // - Prevents typos in password (confirmation field)
        $validated = $request->validate([
            'First_name' => ['required', 'string', 'max:255'],
            'Last_name' => ['required', 'string', 'max:255'],
            'Email' => ['required', 'string', 'email', 'max:255', 'unique:user,Email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // =======================================================================
        // STEP 2: CREATE NEW USER
        // =======================================================================
        //
        // We create a new User model instance (an object representing a row in the database)
        $user = new User();
        
        // Call the register() method on the User model
        //
        // WHY USE A CUSTOM register() METHOD:
        // - Encapsulates user creation logic in the model
        // - Can add additional logic (sending welcome email, logging, etc.) in one place
        // - Keeps controller code clean
        //
        // WHAT register() DOES (defined in User.php):
        // 1. Sets First_name, Last_name, Email
        // 2. Hashes the password using Hash::make()
        // 3. Saves the user to the database
        // 4. Returns the created user
        //
        // Password is NEVER stored in plain text
        // Hash example: "mypassword" -> "$2y$10$abcdef1234567890..."
        $user->register(
            $validated['First_name'],    // e.g., "John"
            $validated['Last_name'],     // e.g., "Doe"
            $validated['Email'],         // e.g., "john@example.com"
            $validated['password']       // e.g., "mypassword123" (will be hashed in register())
        );

        // =======================================================================
        // STEP 3: AUTO-LOGIN AFTER REGISTRATION
        // =======================================================================
        //
        // Better user experience: User doesn't have to log in again after registering
        //
        // Create AuthManager instance
        $authManager = new AuthManager();
        
        // rememberUser() does two things:
        // 1. Logs the user in (creates session)
        // 2. Creates a remember_token (persistent login)
        //
        // $user->User_id is the primary key of the newly created user
        // Note: It's User_id (capital U) because the database column is named that way
        //
        // WHY rememberUser() INSTEAD OF Auth::login():
        // - rememberUser() sets up "remember me" automatically
        // - User stays logged in even after closing browser
        // - Better UX for new users
        $authManager->rememberUser($user->User_id);

        // =======================================================================
        // STEP 4: REDIRECT TO HOME
        // =======================================================================
        //
        // User is now registered and logged in
        // Send them to the home page to start using the application
        //
        // route('home') generates URL for route named 'home'
        return redirect(route('home'));
    }

    /**
     * ==========================================================================
     * LOG OUT USER
     * ==========================================================================
     * 
     * WHAT THIS DOES:
     * Logs the current user out and destroys their session
     * 
     * HOW IT WORKS:
     * 1. User clicks "Logout" button
     * 2. Form submits POST request to /logout
     * 3. This method runs
     * 4. AuthManager logs user out (removes from Auth system)
     * 5. Session is invalidated (destroyed)
     * 6. CSRF token is regenerated (security)
     * 7. User is redirected to login page
     * 
     * SECURITY:
     * - Must be POST request (not GET) to prevent CSRF attacks
     * - Session is completely destroyed (can't be reused)
     * - New CSRF token prevents any pending malicious requests
     * 
     * @param Request $request The HTTP request
     * @return \Illuminate\Http\RedirectResponse Redirects to login page
     */
    public function logout_user(Request $request)
    {
        // =======================================================================
        // STEP 1: LOGOUT FROM AUTH SYSTEM
        // =======================================================================
        //
        // AuthManager->logoutUser() calls Auth::logout() internally
        // This removes the user from Laravel's authentication system
        //
        // WHAT IT DOES:
        // - Removes user ID from session
        // - Removes remember_token from database
        // - User is no longer considered "logged in"
        $authManager = new AuthManager();
        $authManager->logoutUser();

        // =======================================================================
        // STEP 2: INVALIDATE SESSION
        // =======================================================================
        //
        // $request->session()->invalidate() completely destroys the session
        //
        // WHAT THIS MEANS:
        // - All session data is deleted
        // - Session file on server is deleted
        // - Session cookie in browser is deleted
        //
        // WHY:
        // - Security: Prevents session replay attacks
        // - Privacy: Removes any stored user data from session
        // - Clean slate: Next login gets a fresh session
        $request->session()->invalidate();

        // =======================================================================
        // STEP 3: REGENERATE CSRF TOKEN
        // =======================================================================
        //
        // $request->session()->regenerateToken() creates a new CSRF token
        //
        // CSRF (Cross-Site Request Forgery) tokens prevent malicious sites
        // from submitting forms on behalf of the user
        //
        // WHY REGENERATE:
        // - Old token is now invalid
        // - Any forms using old token will fail
        // - Prevents any pending malicious requests from succeeding
        //
        // WHAT IS CSRF:
        // Without this, a malicious site could do:
        // <form action="yoursite.com/logout" method="POST">
        //   <input type="submit" value="Click me!">
        // </form>
        // And if user clicks, they're logged out without knowing
        //
        // WITH CSRF tokens:
        // The form needs a valid @csrf token that only your site can generate
        // Malicious sites can't get this token, so the form fails
        $request->session()->regenerateToken();

        // =======================================================================
        // STEP 4: REDIRECT TO LOGIN
        // =======================================================================
        //
        // User is now fully logged out
        // Send them to login page
        //
        // route('login') generates URL for route named 'login'
        // Typically /login
        return redirect(route('login'));
    }
}

// ==============================================================================
// END OF AuthController
// ==============================================================================
//
// SUMMARY OF WHAT THIS CONTROLLER DOES:
// 
// 1. show_login()      → Display login form
// 2. login_user()      → Process login, validate credentials, create session
// 3. show_register()   → Display registration form
// 4. register_user()   → Create new user, hash password, auto-login
// 5. logout_user()     → Destroy session, redirect to login
//
// SECURITY FEATURES:
// - Session regeneration prevents fixation attacks
// - Password hashing protects user passwords
// - CSRF protection prevents unauthorized form submissions
// - "Remember me" uses secure tokens
// - Generic error messages prevent email enumeration
//
// DATABASE TABLES USED:
// - 'user' table (First_name, Last_name, Email, Password, remember_token)
//
// ROUTES THAT USE THIS CONTROLLER:
// - GET  /login       → show_login()
// - POST /login       → login_user()
// - GET  /register    → show_register()
// - POST /register    → register_user()
// - POST /logout      → logout_user()
// ==============================================================================
