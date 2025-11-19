<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class LoginTest
 * 
 * Feature tests for the Login functionality.
 * Tests success and failure scenarios as per requirements.
 * 
 * @package Tests\Feature
 * @author Agent
 */
class LoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test successful login redirects to home.
     * 
     * Requirement: A user with correct credentials is logged in and redirected to their dashboard.
     * 
     * @return void
     */
    public function test_successful_login_redirects_to_home()
    {
        $user = new User();
        $user->register('Test', 'User', 'test@example.com', 'password123');

        $response = $this->post(route('login'), [
            'Email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('home'));
        $this->assertAuthenticatedAs($user);
    }

    /**
     * Test login with remember me option.
     * 
     * Requirement: If the "Remember Me" option is selected, a persistent token is stored.
     * 
     * @return void
     */
    public function test_login_with_remember_me()
    {
        $user = new User();
        $user->register('Test', 'User', 'remember@example.com', 'password123');

        $response = $this->post(route('login'), [
            'Email' => 'remember@example.com',
            'password' => 'password123',
            'remember' => true,
        ]);

        $response->assertRedirect(route('home'));
        $this->assertAuthenticatedAs($user);
    }

    /**
     * Test login with incorrect credentials shows error.
     * 
     * Requirement: If credentials are incorrect, a generic "Invalid email or password" error is displayed.
     * 
     * @return void
     */
    public function test_login_with_incorrect_credentials_shows_error()
    {
        $user = new User();
        $user->register('Test', 'User', 'test@example.com', 'password123');

        $response = $this->post(route('login'), [
            'Email' => 'test@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors('Email');
        $this->assertGuest();
    }

    /**
     * Test login with non-existent email shows error.
     * 
     * Requirement: If credentials are incorrect, a generic "Invalid email or password" error is displayed.
     * 
     * @return void
     */
    public function test_login_with_nonexistent_email_shows_error()
    {
        $response = $this->post(route('login'), [
            'Email' => 'nonexistent@example.com',
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors('Email');
        $this->assertGuest();
    }

    /**
     * Test login validation requires email.
     * 
     * @return void
     */
    public function test_login_validation_requires_email()
    {
        $response = $this->post(route('login'), [
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors('Email');
    }

    /**
     * Test login validation requires password.
     * 
     * @return void
     */
    public function test_login_validation_requires_password()
    {
        $response = $this->post(route('login'), [
            'Email' => 'test@example.com',
        ]);

        $response->assertSessionHasErrors('password');
    }

    /**
     * Test login page is accessible.
     * 
     * @return void
     */
    public function test_login_page_is_accessible()
    {
        $response = $this->get(route('login'));

        $response->assertStatus(200);
        $response->assertViewIs('auth.login');
    }
}
