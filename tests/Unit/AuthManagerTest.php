<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Services\AuthManager;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;

/**
 * Class AuthManagerTest
 * 
 * Unit tests for the AuthManager service.
 * 
 * @package Tests\Unit
 * @author Agent
 */
class AuthManagerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test authenticate method with valid credentials.
     * 
     * @return void
     */
    public function test_authenticate_with_valid_credentials()
    {
        $user = new User();
        $user->register('Alice', 'Wonder', 'alice@example.com', 'password123');

        $authManager = new AuthManager();
        $result = $authManager->authenticate('alice@example.com', 'password123');

        $this->assertTrue($result);
        $this->assertNotNull($authManager->currentUser);
        $this->assertEquals('alice@example.com', $authManager->currentUser->Email);
    }

    /**
     * Test authenticate method with invalid credentials.
     * 
     * @return void
     */
    public function test_authenticate_with_invalid_credentials()
    {
        $user = new User();
        $user->register('Bob', 'Builder', 'bob@example.com', 'password123');

        $authManager = new AuthManager();
        $result = $authManager->authenticate('bob@example.com', 'wrongpassword');

        $this->assertFalse($result);
        $this->assertNull($authManager->currentUser);
    }

    /**
     * Test rememberUser method.
     * 
     * @return void
     */
    public function test_remember_user()
    {
        $user = new User();
        $user->register('Charlie', 'Brown', 'charlie@example.com', 'password123');

        $authManager = new AuthManager();
        $authManager->rememberUser($user->User_id);

        $this->assertTrue(Auth::check());
        $this->assertEquals('charlie@example.com', Auth::user()->Email);
    }

    /**
     * Test logoutUser method.
     * 
     * @return void
     */
    public function test_logout_user()
    {
        $user = new User();
        $user->register('David', 'Lee', 'david@example.com', 'password123');

        Auth::login($user);
        $this->assertTrue(Auth::check());

        $authManager = new AuthManager();
        $authManager->logoutUser();

        $this->assertFalse(Auth::check());
        $this->assertNull($authManager->currentUser);
    }
}
