<?php

namespace Tests\Feature;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * Feature tests for admin authentication functionality.
 * 
 * Tests admin login, registration, logout, and dashboard access protection.
 * Uses the 'admin' guard which authenticates against the 'admins' table.
 * 
 * @package Tests\Feature
 */
class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that the admin login page is accessible.
     * 
     * @return void
     */
    public function test_admin_can_view_login_page()
    {
        $response = $this->get(route('admin.login'));
        $response->assertStatus(200);
    }

    /**
     * Test that a new admin can register successfully.
     * 
     * Verifies admin is created in database and redirected to dashboard.
     * 
     * @return void
     */
    public function test_admin_can_register()
    {
        $response = $this->post(route('admin.register'), [
            'name' => 'Test Admin',
            'email' => 'admin@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $this->assertDatabaseHas('admins', [
            'email' => 'admin@example.com',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticated('admin');
    }

    /**
     * Test that an existing admin can login.
     * 
     * Creates an admin, attempts login, and verifies authentication.
     * 
     * @return void
     */
    public function test_admin_can_login()
    {
        $admin = Admin::create([
            'name' => 'Test Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->post(route('admin.login'), [
            'email' => 'admin@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($admin, 'admin');
    }

    /**
     * Test that unauthenticated users cannot access admin dashboard.
     * 
     * @return void
     */
    public function test_admin_cannot_access_dashboard_without_login()
    {
        $response = $this->get(route('admin.dashboard'));
        $response->assertRedirect(route('admin.login'));
    }

    /**
     * Test that an admin can logout successfully.
     * 
     * @return void
     */
    public function test_admin_can_logout()
    {
        $admin = Admin::create([
            'name' => 'Test Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);

        $this->actingAs($admin, 'admin');

        $response = $this->post(route('admin.logout'));

        $response->assertRedirect(route('admin.login'));
        $this->assertGuest('admin');
    }
}
