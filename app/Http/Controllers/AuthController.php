<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Services\AuthManager;

/**
 * Handles all authentication for customers/users.
 * 
 * This controller manages user login, registration, and logout.
 * Admins use a separate controller (AdminAuthController).
 * 
 * @package App\Http\Controllers
 */
class AuthController extends Controller
{
    /**
     * Display the login form.
     * 
     * @return \Illuminate\View\View
     */
    public function show_login()
    {
        // view('auth.login') loads resources/views/auth/login.blade.php
        return view('auth.login');
    }

    /**
     * Process user login attempt.
     * 
     * Validates credentials, authenticates user, handles "remember me",
     * and redirects to dashboard on success.
     * 
     * @param  \Illuminate\Http\Request  $request  Contains Email, password, remember
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login_user(Request $request)
    {
        // Validate: Email must be valid format, password must exist
        $credentials = $request->validate([
            'Email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Create AuthManager to handle authentication logic
        $authManager = new AuthManager();
        
        // Attempt to authenticate with provided credentials
        if ($authManager->authenticate($credentials['Email'], $credentials['password'])) {
            // Regenerate session ID to prevent session fixation attacks
            $request->session()->regenerate();

            // If "remember me" checkbox was checked, create persistent login token
            if ($request->has('remember')) {
                $authManager->rememberUser(Auth::id());
            }

            // Redirect to intended page or dashboard
            return redirect()->intended(route('dashboard'));
        }

        // Authentication failed - redirect back with error
        // Generic error message prevents email enumeration attacks
        return back()->withErrors([
            'Email' => 'The provided credentials do not match our records.',
        ])->onlyInput('Email');
    }

    /**
     * Display the registration form.
     * 
     * @return \Illuminate\View\View
     */
    public function show_register()
    {
        // view('auth.register') loads resources/views/auth/register.blade.php
        return view('auth.register');
    }

    /**
     * Process user registration.
     * 
     * Creates a new user account with hashed password and
     * automatically logs them in with "remember me" enabled.
     * 
     * @param  \Illuminate\Http\Request  $request  Contains First_name, Last_name, Email, password
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register_user(Request $request)
    {
        // Validate all registration fields
        // 'unique:user,Email' ensures no duplicate email addresses
        // 'confirmed' checks that password matches password_confirmation
        $validated = $request->validate([
            'First_name' => ['required', 'string', 'max:255'],
            'Last_name' => ['required', 'string', 'max:255'],
            'Email' => ['required', 'string', 'email', 'max:255', 'unique:user,Email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // Create new User instance
        $user = new User();
        
        // User->register() hashes the password and saves to database
        $user->register(
            $validated['First_name'],
            $validated['Last_name'],
            $validated['Email'],
            $validated['password']
        );

        // Auto-login the new user with "remember me" enabled
        $authManager = new AuthManager();
        $authManager->rememberUser($user->User_id);

        // Redirect to dashboard
        return redirect(route('dashboard'));
    }

    /**
     * Log the user out.
     * 
     * Destroys session, clears authentication, regenerates CSRF token,
     * and redirects to login page.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout_user(Request $request)
    {
        // Logout from Auth system
        $authManager = new AuthManager();
        $authManager->logoutUser();

        // Invalidate the entire session
        $request->session()->invalidate();

        // Regenerate CSRF token to prevent pending malicious requests
        $request->session()->regenerateToken();

        // Redirect to login page
        return redirect(route('login'));
    }
}
