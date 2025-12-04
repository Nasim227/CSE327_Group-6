<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * Handles authentication for admin/staff users.
 * 
 * This controller manages admin login, registration, and logout using
 * a separate 'admin' guard. Admins authenticate against the 'admins' table
 * and have different permissions than regular users.
 * 
 * @package App\Http\Controllers
 */
class AdminAuthController extends Controller
{
    /**
     * Display the admin login form.
     * 
     * @return \Illuminate\View\View
     */
    public function showLogin()
    {
        return view('admin.login');
    }

    /**
     * Authenticate an admin user.
     * 
     * Validates credentials and attempts login using the 'admin' guard.
     * On success, regenerates session and redirects to admin dashboard.
     * 
     * @param  \Illuminate\Http\Request  $request  Contains email and password
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        // Validate input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Attempt authentication with admin guard
        if (Auth::guard('admin')->attempt($credentials)) {
            // Regenerate session for security
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        // Authentication failed
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Display the admin registration form.
     * 
     * @return \Illuminate\View\View
     */
    public function showRegister()
    {
        return view('admin.register');
    }

    /**
     * Create a new admin account.
     * 
     * Validates input, creates the admin with hashed password,
     * automatically logs them in, and redirects to dashboard.
     * 
     * @param  \Illuminate\Http\Request  $request  Contains name, email, password
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        // Validate registration data
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admins'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // Create admin with hashed password
        $admin = Admin::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        // Auto-login the new admin
        Auth::guard('admin')->login($admin);

        return redirect(route('admin.dashboard'));
    }

    /**
     * Log the admin out.
     * 
     * Logs out from admin guard, invalidates session,
     * regenerates CSRF token, and redirects to admin login.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        // Logout from admin guard only
        Auth::guard('admin')->logout();
        
        // Invalidate session
        $request->session()->invalidate();
        
        // Regenerate CSRF token
        $request->session()->regenerateToken();

        return redirect(route('admin.login'));
    }
}
