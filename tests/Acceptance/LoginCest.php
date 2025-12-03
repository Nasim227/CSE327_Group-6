<?php

namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;

/**
 * Codeception acceptance test for Login functionality.
 * 
 * Tests the complete user flow for logging in via browser.
 * 
 * @package Tests\Acceptance
 * @author Agent
 */
class LoginCest
{
    /**
     * Setup before each test.
     * 
     * @param AcceptanceTester $I
     * @return void
     */
    public function _before(AcceptanceTester $I)
    {
        // Create a test user before each test
        $I->haveInDatabase('user', [
            'First_name' => 'Test',
            'Last_name' => 'User',
            'Email' => 'test@example.com',
            'Password' => '$2y$04$VZWEgNZLHvZfBbXHrQmFi.xf4fH8gR/xQjpAiV3UvNB8CdxvH3HKu', // password: password123
        ]);
    }

    /**
     * Test successful login flow.
     * 
     * @param AcceptanceTester $I
     * @return void
     */
    public function testSuccessfulLogin(AcceptanceTester $I)
    {
        $I->wantTo('log in with valid credentials');
        $I->amOnPage('/login');
        $I->see('CMS LOGIN');
        
        $I->fillField('Email', 'test@example.com');
        $I->fillField('password', 'password123');
        $I->click('LOG IN');
        
        $I->seeCurrentUrlEquals('/');
        $I->dontSee('CMS LOGIN');
    }

    /**
     * Test login with invalid credentials.
     * 
     * @param AcceptanceTester $I
     * @return void
     */
    public function testLoginWithInvalidCredentials(AcceptanceTester $I)
    {
        $I->wantTo('see error message with invalid credentials');
        $I->amOnPage('/login');
        
        $I->fillField('Email', 'test@example.com');
        $I->fillField('password', 'wrongpassword');
        $I->click('LOG IN');
        
        $I->seeCurrentUrlEquals('/login');
        $I->see('do not match');
    }

    /**
     * Test login page displays correctly.
     * 
     * @param AcceptanceTester $I
     * @return void
     */
    public function testLoginPageDisplays(AcceptanceTester $I)
    {
        $I->wantTo('see the login page');
        $I->amOnPage('/login');
        
        $I->see('CMS LOGIN');
        $I->seeElement('input[name="Email"]');
        $I->seeElement('input[name="password"]');
        $I->seeElement('button[type="submit"]');
        $I->see('Remember me');
        $I->see('Forgot password?');
        $I->see('Don\'t have an account?');
    }
}
