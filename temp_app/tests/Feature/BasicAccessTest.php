<?php

namespace Tests\Feature;

use Tests\TestCase;

class BasicAccessTest extends TestCase
{
    /**
     * Test the home page returns a successful response.
     */
    public function test_home_page_returns_successful_response()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * Test the login page returns a successful response.
     */
    public function test_login_page_returns_successful_response()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    /**
     * Test a non-existent page returns a 404 response.
     */
    public function test_non_existent_page_returns_404()
    {
        $response = $this->get('/non-existent-page');

        $response->assertStatus(404);
    }
}
