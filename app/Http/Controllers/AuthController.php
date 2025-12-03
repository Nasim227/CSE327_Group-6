<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Services\AuthManager;

/**
 * Authentication Controller
 * 
 * Handles all customer/user authentication operations including:
 * - Displaying login and registration forms
 * - Processing login credentials
 * - Creating new user accounts
 * - Logging users out
 * 
 * This controller is separate from AdminAuthController to maintain
 * clear separation between customer and admin authentication.
 * 
 * @package App\Http\Controllers
 */
class AuthController extends Controller
{
    /**
     * Display the login page
     * 
     * @return \Illuminate\View\View
     */
    public function show_login()
    {
        return view('auth.login');
    }

    /**
     * Process user login
     * 
     * Validates email and password, then authenticates the user.
     * If "remember me" is checked, creates a persistent login token.
     * 
     * @param Request $request The HTTP request containing email, password, and optional remember checkbox
     * @return \Illuminate\Http\RedirectResponse Redirects to home on success, back to login on failure
     */
    public function login_user(Request $request)
    {
        $credentials = $request->validate([
            'Email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $authManager = new AuthManager();
        
        if ($authManager->authenticate($credentials['Email'], $credentials['password'])) {
            $request->session()->regenerate();

            if ($request->has('remember')) {
                $authManager->rememberUser(Auth::id());
            }

            return redirect()->intended(route('home'));
        }

        return back()->withErrors([
            'Email' => 'The provided credentials do not match our records.',
        ])->onlyInput('Email');
    }

    /**
     * Display the registration page
     * 
     * @return \Illuminate\View\View
     */
    public function show_register()
    {
        return view('auth.register');
    }

    /**
     * Process user registration
     * 
     * Creates a new user account with hashed password and automatically
     * logs them in using the "remember me" functionality.
     * 
     * @param Request $request The HTTP request containing first_name, last_name, email, password, password_confirmation
     * @return \Illuminate\Http\RedirectResponse Redirects to home page after successful registration
     */
    public function register_user(Request $request)
    {
        $validated = $request->validate([
            'First_name' => ['required', 'string', 'max:255'],
            'Last_name' => ['required', 'string', 'max:255'],
            'Email' => ['required', 'string', 'email', 'max:255', 'unique:user,Email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = new User();
        $user->register(
            $validated['First_name'],
            $validated['Last_name'],
            $validated['Email'],
            $validated['password']
        );

        // Auto login after registration
        $authManager = new AuthManager();
        $authManager->rememberUser($user->User_id);

        return redirect(route('home'));
    }

    /**
     * Log the user out of the application.
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout_user(Request $request)
    {
        $authManager = new AuthManager();
        $authManager->logoutUser();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(route('login'));
    }
}
