<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Services\AuthManager;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserModelTest
 * 
 * Unit tests for the User model.
 * 
 * @package Tests\Unit
 * @author Agent
 */
class UserModelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test user registration creates a new user.
     * 
     * @return void
     */
    public function test_register_creates_new_user()
    {
        $user = new User();
        $user->register('John', 'Doe', 'john@example.com', 'password123');

        $this->assertDatabaseHas('user', [
            'Email' => 'john@example.com',
            'First_name' => 'John',
            'Last_name' => 'Doe',
        ]);
    }

    /**
     * Test user login with valid credentials.
     * 
     * @return void
     */
    public function test_login_with_valid_credentials()
    {
        $user = new User();
        $user->register('Jane', 'Doe', 'jane@example.com', 'password123');

        $result = $user->login('jane@example.com', 'password123');

        $this->assertTrue($result);
    }

    /**
     * Test user login with invalid credentials.
     * 
     * @return void
     */
    public function test_login_with_invalid_credentials()
    {
        $user = new User();
        $user->register('Jane', 'Doe', 'jane@example.com', 'password123');

        $result = $user->login('jane@example.com', 'wrongpassword');

        $this->assertFalse($result);
    }

    /**
     * Test update profile method.
     * 
     * @return void
     */
    public function test_update_profile()
    {
        $user = new User();
        $user->register('Bob', 'Smith', 'bob@example.com', 'password123');

        $updated = $user->updateProfile([
            'First_name' => 'Robert',
            'Last_name' => 'Smith Jr.',
        ]);

        $this->assertTrue($updated);
        $this->assertEquals('Robert', $user->fresh()->First_name);
        $this->assertEquals('Smith Jr.', $user->fresh()->Last_name);
    }

    /**
     * Test password hashing on registration.
     * 
     * @return void
     */
    public function test_password_is_hashed_on_registration()
    {
        $user = new User();
        $user->register('Test', 'User', 'test@example.com', 'plainpassword');

        $this->assertNotEquals('plainpassword', $user->Password);
        $this->assertTrue(Hash::check('plainpassword', $user->Password));
    }
}
