<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Services\AuthManager;

/**
 * Class AuthController
 * 
 * Handles user authentication requests.
 * 
 * @package App\Http\Controllers
 * @author Agent
 */
class AuthController extends Controller
{
    /**
     * Show the login form.
     * 
     * @return \Illuminate\View\View
     */
    public function show_login()
    {
        return view('auth.login');
    }

    /**
     * Handle user login request.
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
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
     * Show the registration form.
     * 
     * @return \Illuminate\View\View
     */
    public function show_register()
    {
        return view('auth.register');
    }

    /**
     * Handle user registration request.
     * 
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
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
