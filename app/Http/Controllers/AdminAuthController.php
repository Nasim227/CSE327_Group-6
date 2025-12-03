<?php

// ==============================================================================
// NAMESPACE DECLARATION
// ==============================================================================
//
// This class is inside the App\Http\Controllers namespace
// Same concept as AuthController, but this one is for ADMIN authentication
namespace App\Http\Controllers;

// ==============================================================================
// IMPORTING CLASSES
// ==============================================================================

use App\Models\Admin;                      // The Admin model (represents admin users in database)
use Illuminate\Http\Request;               // Handles HTTP requests
use Illuminate\Support\Facades\Auth;       // Laravel's authentication system
use Illuminate\Support\Facades\Hash;       // For hashing passwords securely

/**
 * ==============================================================================
 * ADMIN AUTHENTICATION CONTROLLER  
 * ==============================================================================
 * 
 * PURPOSE:
 * This controller handles authentication for ADMINS/STAFF ONLY (not customers)
 * 
 * KEY DIFFERENCE FROM AuthController:
 * - Uses 'admin' guard instead of default 'web' guard
 * - Authenticates against 'admins' table instead of 'user' table
 * - Redirects to admin dashboard instead of customer home
 * - Has different permissions and access levels
 * 
 * WHY SEPARATE CONTROLLERS:
 * 1. SECURITY: Admins and customers must never share sessions
 * 2. PERMISSIONS: Admins can manage the system, customers cannot
 * 3. DATABASE: Different tables with different columns
 * 4. UI: Different dashboard pages and features
 * 
 * WHAT ARE "GUARDS":
 * Guards are like different "authentication systems" within one app
 * Think of them as separate "doors" with different keys:
 * - 'web' guard = Customer door (uses 'user' table)
 * - 'admin' guard = Staff door (uses 'admins' table)
 * - You can be logged in to one guard but not the other simultaneously
 * 
 * EXAMPLE SCENARIO:
 * - Customer logs in → 'web' guard is active → sees customer dashboard
 * - Admin logs in → 'admin' guard is active → sees admin dashboard
 * - They're completely separate sessions, even if same person
 * 
 * @package App\Http\Controllers
 */
class AdminAuthController extends Controller
{
    /**
     * ==========================================================================
     * SHOW ADMIN LOGIN PAGE
     * ==========================================================================
     * 
     * WHAT THIS DOES:
     * Displays the login form specifically for administrators
     * 
     * HOW IT WORKS:
     * 1. Admin visits /admin/login
     * 2. This method runs
     * 3. Returns the admin login view
     * 
     * DIFFERENCE FROM USER LOGIN:
     * - Different URL (/admin/login vs /login)
     * - Different view (admin.login vs auth.login)
     * - May have different styling or branding
     * 
     * @return \Illuminate\View\View Returns the admin login view
     */
    public function showLogin()
    {
        // view('admin.login') looks for: resources/views/admin/login.blade.php
        // This is the admin-specific login form
        return view('admin.login');
    }

    /**
     * ==========================================================================
     * PROCESS ADMIN LOGIN
     * ==========================================================================
     * 
     * WHAT THIS DOES:
     * Authenticates an admin user using the 'admin' guard
     * 
     * HOW IT WORKS:
     * 1. Admin submits login form (email + password)
     * 2. Validate the inputs
     * 3. Attempt login using 'admin' guard (NOT default 'web' guard)
     * 4. If successful: regenerate session & redirect to admin dashboard
     * 5. If failed: return to login with error
     * 
     * THE 'ADMIN' GUARD:
     * Auth::guard('admin') tells Laravel:
     * "Use the admin authentication system"
     * 
     * This is configured in config/auth.php:
     * 'guards' => [
     *     'web' => [...],    // For customers
     *     'admin' => [       // For admins
     *         'driver' => 'session',
     *         'provider' => 'admins',
     *     ],
     * ]
     * 
     * 'providers' => [
     *     'admins' => [
     *         'driver' => 'eloquent',
     *         'model' => App\Models\Admin::class,  // Uses Admin model
     *     ],
     * ]
     * 
     * WHY TWO GUARDS:
     * Imagine a shopping mall:
     * - 'web' guard = Customer entrance (public, anyone can enter)
     * - 'admin' guard = Staff entrance (restricted, badge required)
     * - Same building, different doors, different privileges
     * 
     * @param Request $request Contains 'email' and 'password'
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        // =======================================================================
        // STEP 1: VALIDATE INPUT
        // =======================================================================
        //
        // Same validation as user login:
        // - email must be present and valid format
        // - password must be present
        //
        // Note: Field names are lowercase ('email', 'password')
        // User login uses 'Email' (capital E) because database column is 'Email'
        // Admin login uses 'email' (lowercase) because 'admins' table uses 'email'
        //
        // This inconsistency is common in legacy databases - be careful!
        $credentials = $request->validate([
            'email' => ['required', 'email'],          // Must be valid email format
            'password' => ['required'],                 // Must not be empty
        ]);

        // =======================================================================
        // STEP 2: ATTEMPT AUTHENTICATION WITH 'ADMIN' GUARD
        // =======================================================================
        //
        // Auth::guard('admin')->attempt($credentials)
        //
        // WHAT THIS DOES:
        // 1. Looks up admin in 'admins' table by email
        // 2. Compares password hash with submitted password
        // 3. If match: logs admin in and returns true
        // 4. If no match: returns false
        //
        // DIFFERENCE FROM AuthController:
        // - AuthController uses AuthManager service
        // - AdminAuthController uses Auth::guard('admin')->attempt() directly
        //
        // WHY THE DIFFERENCE:
        // - Both approaches work fine
        // - AuthManager provides extra abstraction/reusability
        // - Direct Auth::attempt() is simpler and more Laravel-standard
        //
        // WHAT ->attempt() DOES INTERNALLY:
        // 1. Finds admin where email = $credentials['email']
        // 2. Runs Hash::check($credentials['password'], $admin->password)
        // 3. If true: Sets session variables, marks admin as authenticated
        // 4. Returns boolean result
        if (Auth::guard('admin')->attempt($credentials)) {
            // ===================================================================
            // AUTHENTICATION SUCCESSFUL
            // ===================================================================

            // Regenerate session ID for security
            //
            // WHY:
            // Prevents session fixation attacks (same as AuthController)
            // Old session ID is thrown away, new one created
            // Admin's data is preserved but session ID changes
            $request->session()->regenerate();

            // Redirect to admin dashboard
            //
            // redirect()->intended() is smart:
            // - If admin tried to access protected page (e.g., /admin/users)
            //   and was redirected to login, now sends them to /admin/users
            // - If they came directly to /admin/login, sends them to dashboard
            //
            // route('admin.dashboard') generates URL for:
            // Route::get('/admin/dashboard', ...)->name('admin.dashboard');
            return redirect()->intended(route('admin.dashboard'));
        }

        // =======================================================================
        // AUTHENTICATION FAILED
        // =======================================================================
        //
        // Same error handling as AuthController:
        // - back() returns to login page
        // - withErrors() adds error message
        // - onlyInput('email') remembers email but not password
        //
        // SECURITY NOTE:
        // Generic error message prevents email enumeration
        // Attacker can't determine if email exists or password is wrong
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * ==========================================================================
     * SHOW ADMIN REGISTRATION PAGE
     * ==========================================================================
     * 
     * WHAT THIS DOES:
     * Displays the form where new admin accounts are created
     * 
     * SECURITY CONSIDERATION:
     * In production, you might want to:
     * - Disable this route (admins created by super-admin only)
     * - Add invite token verification
     * - Require approval before admin account is active
     * 
     * For this project, it's open for demonstration purposes
     * 
     * @return \Illuminate\View\View
     */
    public function showRegister()
    {
        // view('admin.register') looks for: resources/views/admin/register.blade.php
        return view('admin.register');
    }

    /**
     * ==========================================================================
     * PROCESS ADMIN REGISTRATION
     * ==========================================================================
     * 
     * WHAT THIS DOES:
     * Creates a new admin account and logs them in automatically
     * 
     * HOW IT WORKS:
     * 1. Validate all inputs (name, email, password)
     * 2. Create new Admin record in database
     * 3. Hash the password before storing
     * 4. Auto-login the new admin
     * 5. Redirect to admin dashboard
     * 
     * KEY DIFFERENCES FROM USER REGISTRATION:
     * - Uses Admin::create() instead of User->register()
     * - Only requires 'name' (single field) vs First_name + Last_name
     * - Uses Hash::make() explicitly (User model hides this in register())
     * - Uses Auth::guard('admin')->login() instead of AuthManager
     * 
     * @param Request $request Contains name, email, password, password_confirmation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        // =======================================================================
        // STEP 1: VALIDATE REGISTRATION DATA
        // =======================================================================
        //
        // VALIDATION RULES:
        //
        // name:
        // - 'required': Cannot be empty
        // - 'string': Must be text
        // - 'max:255': Maximum 255 characters
        //
        // email:
        // - 'required': Cannot be empty
        // - 'string': Must be text
        // - 'email': Must be valid email format
        // - 'max:255': Maximum 255 characters
        // - 'unique:admins': Email must not already exist in 'admins' table
        //                    Note: Different from user registration which checks 'user' table
        //
        // password:
        // - 'required': Cannot be empty
        // - 'string': Must be text
        // - 'min:8': At least 8 characters
        // - 'confirmed': Must match 'password_confirmation' field
        //                Form must have: <input name="password_confirmation">
        //
        // WHY 'unique:admins' NOT 'unique:user':
        // - Admins and users are in separate tables
        // - Same email could theoretically be both admin and customer
        // - But typically you'd prevent this for clarity
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admins'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // =======================================================================
        // STEP 2: CREATE NEW ADMIN
        // =======================================================================
        //
        // Admin::create() is Laravel's "mass assignment" method
        //
        // WHAT IT DOES:
        // 1. Creates new Admin model instance
        // 2. Sets name, email, password fields
        // 3. Saves to database
        // 4. Returns the created Admin object
        //
        // HOW PASSWORD HASHING WORKS:
        // Hash::make($password) converts plain password to secure hash
        // Example: "mypassword" → "$2y$10$abcdef1234567890..."
        //
        // WHY HASH::MAKE() HERE BUT NOT IN USER REGISTRATION:
        // - User model has a custom register() method that handles hashing
        // - Admin uses standard create() so we hash manually
        // - Both approaches are secure, just different coding styles
        //
        // ALTERNATIVE APPROACH:
        // We could add a register() method to Admin model like User has
        // Then code would look like: $admin = new Admin(); $admin->register(...);
        //
        // SECURITY NOTE:
        // Password is NEVER stored in plain text
        // Even database admins can't see actual passwords
        // Hashing is one-way (can't "unhash" to get original password)
        $admin = Admin::create([
            'name' => $validated['name'],                        // e.g., "John Smith"
            'email' => $validated['email'],                      // e.g., "john@company.com"
            'password' => Hash::make($validated['password']),    // e.g., "$2y$10$abc..."
        ]);

        // =======================================================================
        // STEP 3: AUTO-LOGIN THE NEW ADMIN
        // =======================================================================
        //
        // Auth::guard('admin')->login($admin)
        //
        // WHAT THIS DOES:
        // 1. Creates session for this admin
        // 2. Stores admin's ID in session
        // 3. Marks them as authenticated on 'admin' guard
        //
        // WHY AUTO-LOGIN:
        // Better user experience - admin doesn't have to log in right after registering
        //
        // PASSING THE ADMIN OBJECT:
        // We pass $admin (the Admin model instance we just created)
        // Laravel automatically extracts the ID and stores it in session
        //
        // DIFFERENCE FROM USER REGISTRATION:
        // - User registration uses AuthManager->rememberUser()
        // - Admin registration uses Auth::guard('admin')->login()
        // - Both achieve same result, different approaches
        Auth::guard('admin')->login($admin);

        // =======================================================================
        // STEP 4: REDIRECT TO ADMIN DASHBOARD
        // =======================================================================
        //
        // Admin is now created and logged in
        // Send them straight to the admin control panel
        //
        // route('admin.dashboard') generates the URL for admin dashboard
        // Typically /admin/dashboard
        return redirect(route('admin.dashboard'));
    }

    /**
     * ==========================================================================
     * LOG OUT ADMIN
     * ==========================================================================
     * 
     * WHAT THIS DOES:
     * Logs the admin out and destroys their session
     * 
     * HOW IT WORKS:
     * 1. Admin clicks "Logout" button
     * 2. Form posts to /admin/logout
     * 3. This method runs
     * 4. admin guard logout
     * 5. Session invalidated
     * 6. CSRF token regenerated
     * 7. Redirect to admin login page
     * 
     * SECURITY:
     * - Same security measures as user logout
     * - Session completely destroyed
     * - New CSRF token prevents any pending requests
     * 
     * KEY DIFFERENCE FROM USER LOGOUT:
     * - Uses Auth::guard('admin')->logout() instead of AuthManager
     * - Redirects to admin.login instead of regular login
     * - Only affects admin session, not user session
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        // =======================================================================
        // STEP 1: LOGOUT FROM ADMIN GUARD
        // =======================================================================
        //
        // Auth::guard('admin')->logout()
        //
        // WHAT THIS DOES:
        // 1. Removes admin ID from session
        // 2. Clears admin guard authentication
        // 3. Admin is no longer considered "logged in"
        //
        // IMPORTANT:
        // This only logs out from 'admin' guard
        // If same person is logged in as customer on 'web' guard, that stays active
        //
        // EXAMPLE SCENARIO:
        // - Person logs in as customer (web guard active)
        // - Then logs in as admin in different tab (admin guard active)
        // - Logs out from admin → admin guard cleared, web guard still active
        // - Customer session continues, admin session ends
        Auth::guard('admin')->logout();

        // =======================================================================
        // STEP 2: INVALIDATE SESSION
        // =======================================================================
        //
        // Completely destroys the session
        // Same as user logout - all session data deleted
        //
        // WHY:
        // - Security: prevents session replay
        // - Privacy: removes any sensitive data
        // - Clean state: next login gets fresh session
        $request->session()->invalidate();

        // =======================================================================
        // STEP 3: REGENERATE CSRF TOKEN
        // =======================================================================
        //
        // Creates new CSRF token
        // Old token is now invalid
        //
        // WHY:
        // - Prevents CSRF attacks using old token
        // - Any pending form submissions will fail
        // - Next page load gets new token
        $request->session()->regenerateToken();

        // =======================================================================
        // STEP 4: REDIRECT TO ADMIN LOGIN
        // =======================================================================
        //
        // Admin is now fully logged out
        // Send them to admin login page
        //
        // route('admin.login') generates URL for /admin/login
        return redirect(route('admin.login'));
    }
}

// ==============================================================================
// END OF AdminAuthController
// ==============================================================================
//
// SUMMARY OF WHAT THIS CONTROLLER DOES:
//
// 1. showLogin()   → Display admin login form
// 2. login()       → Authenticate admin using 'admin' guard
// 3. showRegister() → Display admin registration form
// 4. register()    → Create new admin account, auto-login
// 5. logout()      → Log out admin, destroy session
//
// KEY DIFFERENCES FROM AuthController:
// - Uses 'admin' guard instead of 'web' guard
// - Authenticates against 'admins' table instead of 'user' table
// - Uses Admin model instead of User model
// - Redirects to admin.dashboard instead of home
// - Field names are lowercase (email) vs User (Email)
//
// GUARDS EXPLAINED:
// - 'web' guard (default) = For customers, uses 'user' table
// - 'admin' guard = For staff, uses 'admins' table
// - Two separate authentication systems in one application
// - Can be logged into both simultaneously (different sessions)
//
// SECURITY FEATURES:
// - Session regeneration prevents fixation
// - Password hashing protects credentials
// - CSRF protection on all forms
// - Generic error messages prevent enumeration
// - Complete session destruction on logout
//
// DATABASE TABLES USED:
// - 'admins' table (id, name, email, password, remember_token, created_at, updated_at)
//
// ROUTES THAT USE THIS CONTROLLER:
// - GET  /admin/login      → showLogin()
// - POST /admin/login      → login()
// - GET  /admin/register   → showRegister()
// - POST /admin/register   → register()
// - POST /admin/logout     → logout()
// ==============================================================================
