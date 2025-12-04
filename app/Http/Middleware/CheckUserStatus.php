<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware to enforce user account status.
 * 
 * This middleware checks if the currently logged-in user has an 'inactive' status.
 * If so, they are immediately logged out and redirected to the login page with an error message.
 * 
 * @package App\Http\Middleware
 */
class CheckUserStatus
{
    /**
     * Handle an incoming request.
     * 
     * Checks if the authenticated user's account status is 'inactive'.
     * If inactive, logs them out, invalidates their session, and redirects to login.
     *
     * @param  \Illuminate\Http\Request  $request  The incoming HTTP request
     * @param  \Closure  $next  The next middleware or controller in the pipeline
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is logged in AND their status is 'inactive'
        // Auth::check() returns true if a user is currently authenticated
        // Auth::user()->status accesses the 'status' column from the database
        if (Auth::check() && Auth::user()->status === 'inactive') {
            
            // Log the user out - removes their ID from the session
            Auth::logout();
            
            // Invalidate the session - destroys all session data
            $request->session()->invalidate();
            
            // Regenerate CSRF token - prevents any pending form submissions
            $request->session()->regenerateToken();

            // Redirect to login with an error message
            return redirect()->route('login')->withErrors([
                'email' => 'Your account has been deactivated. Please contact support.',
            ]);
        }

        // User is active (or not logged in) - continue to the next step
        return $next($request);
    }
}
