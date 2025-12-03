<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class SignupTest
 * 
 * Feature tests for the Signup functionality.
 * Tests success and failure scenarios as per requirements.
 * 
 * @package Tests\Feature
 * @author Agent
 */
class SignupTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test successful registration creates account and auto-logs in.
     * 
     * Requirement: The system creates the account, securely hashes the password, 
     * and redirects the user to the login page or dashboard.
     * 
     * @return void
     */
    public function test_successful_registration_creates_account_and_logs_in()
    {
        $response = $this->post(route('register'), [
            'First_name' => 'John',
            'Last_name' => 'Doe',
            'Email' => 'john@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('home'));

        $this->assertDatabaseHas('user', [
            'Email' => 'john@example.com',
            'First_name' => 'John',
            'Last_name' => 'Doe',
        ]);

        $this->assertAuthenticated();
    }

    /**
     * Test registration with duplicate email shows error.
     * 
     * Requirement: If the email address is already registered, an inline error message appears.
     * 
     * @return void
     */
    public function test_registration_with_duplicate_email_shows_error()
    {
        $user = new User();
        $user->register('Existing', 'User', 'existing@example.com', 'password123');

        $response = $this->post(route('register'), [
            'First_name' => 'New',
            'Last_name' => 'User',
            'Email' => 'existing@example.com',
            'password' => 'password456',
            'password_confirmation' => 'password456',
        ]);

        $response->assertSessionHasErrors('Email');
        $this->assertGuest();
    }

    /**
     * Test registration with weak password shows error.
     * 
     * Requirement: If the form contains invalid data (e.g., weak password), 
     * specific inline errors will detail the required corrections.
     * 
     * @return void
     */
    public function test_registration_with_weak_password_shows_error()
    {
        $response = $this->post(route('register'), [
            'First_name' => 'Test',
            'Last_name' => 'User',
            'Email' => 'test@example.com',
            'password' => 'weak',
            'password_confirmation' => 'weak',
        ]);

        $response->assertSessionHasErrors('password');
        $this->assertGuest();
    }

    /**
     * Test registration with mismatched password confirmation shows error.
     * 
     * @return void
     */
    public function test_registration_with_mismatched_password_confirmation_shows_error()
    {
        $response = $this->post(route('register'), [
            'First_name' => 'Test',
            'Last_name' => 'User',
            'Email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password456',
        ]);

        $response->assertSessionHasErrors('password');
        $this->assertGuest();
    }

    /**
     * Test registration requires first name.
     * 
     * @return void
     */
    public function test_registration_requires_first_name()
    {
        $response = $this->post(route('register'), [
            'Last_name' => 'User',
            'Email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors('First_name');
    }

    /**
     * Test registration requires last name.
     * 
     * @return void
     */
    public function test_registration_requires_last_name()
    {
        $response = $this->post(route('register'), [
            'First_name' => 'Test',
            'Email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors('Last_name');
    }

    /**
     * Test registration requires valid email.
     * 
     * @return void
     */
    public function test_registration_requires_valid_email()
    {
        $response = $this->post(route('register'), [
            'First_name' => 'Test',
            'Last_name' => 'User',
            'Email' => 'invalid-email',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors('Email');
    }

    /**
     * Test registration page is accessible.
     * 
     * @return void
     */
    public function test_registration_page_is_accessible()
    {
        $response = $this->get(route('register'));

        $response->assertStatus(200);
        $response->assertViewIs('auth.register');
    }

    /**
     * Test password is hashed after registration.
     * 
     * Requirement: The system creates the account and securely hashes the password.
     * 
     * @return void
     */
    public function test_password_is_hashed_after_registration()
    {
        $response = $this->post(route('register'), [
            'First_name' => 'Test',
            'Last_name' => 'User',
            'Email' => 'hash@example.com',
            'password' => 'plaintextpassword',
            'password_confirmation' => 'plaintextpassword',
        ]);

        $user = User::where('Email', 'hash@example.com')->first();
        
        $this->assertNotEquals('plaintextpassword', $user->Password);
    }
}
