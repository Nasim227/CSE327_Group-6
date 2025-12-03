<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * Admin Authentication Controller
 * 
 * Handles all administrative authentication operations including:
 * - Displaying admin login and registration forms
 * - Processing admin login credentials
 * - Creating new admin accounts
 * - Logging admins out
 * 
 * Uses the 'admin' guard to ensure complete separation from user sessions.
 * 
 * @package App\Http\Controllers
 */
class AdminAuthController extends Controller
{
    /**
     * Display the admin login page
     * 
     * @return \Illuminate\View\View
     */
    public function showLogin()
    {
        return view('admin.login');
    }

    /**
     * Process admin login
     * 
     * Validates credentials and attempts to log the admin in using the 'admin' guard.
     * Regenerates session on success to prevent fixation attacks.
     * 
     * @param Request $request The HTTP request containing email and password
     * @return \Illuminate\Http\RedirectResponse Redirects to admin dashboard on success
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Display the admin registration page
     * 
     * @return \Illuminate\View\View
     */
    public function showRegister()
    {
        return view('admin.register');
    }

    /**
     * Process admin registration
     * 
     * Creates a new admin account with hashed password and automatically
     * logs them in using the 'admin' guard.
     * 
     * @param Request $request The HTTP request containing name, email, password
     * @return \Illuminate\Http\RedirectResponse Redirects to admin dashboard
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admins'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $admin = Admin::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::guard('admin')->login($admin);

        return redirect(route('admin.dashboard'));
    }

    /**
     * Log the admin out
     * 
     * Invalidates the session and regenerates the CSRF token.
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse Redirects to admin login page
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(route('admin.login'));
    }
}
