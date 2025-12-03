<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * Class AuthManager
 * 
 * Manages user authentication and session handling.
 * 
 * @package App\Services
 * @author Agent
 */
class AuthManager
{
    /**
     * The currently authenticated user.
     * 
     * @var User|null
     */
    public $currentUser;

    /**
     * The remember token for persistent login.
     * 
     * @var string|null
     */
    public $rememberToken;

    /**
     * Authenticate a user with email and password.
     * 
     * @param string $email The user's email.
     * @param string $password The user's password.
     * @return bool True if authentication was successful, false otherwise.
     */
    public function authenticate(string $email, string $password): bool
    {
        $credentials = [
            'Email' => $email,
            'password' => $password
        ];

        if (Auth::attempt($credentials)) {
            $this->currentUser = Auth::user();
            return true;
        }

        return false;
    }

    /**
     * Log in a user and remember them.
     * 
     * @param int $userID The ID of the user to login.
     * @return void
     */
    public function rememberUser(int $userID): void
    {
        Auth::loginUsingId($userID, true);
        $this->currentUser = Auth::user();
    }

    /**
     * Log out the currently authenticated user.
     * 
     * @return void
     */
    public function logoutUser(): void
    {
        Auth::logout();
        $this->currentUser = null;
    }
}
