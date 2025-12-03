<?php

namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;

/**
 * Codeception acceptance test for Signup functionality.
 * 
 * Tests the complete user flow for registration via browser.
 * 
 * @package Tests\Acceptance
 * @author Agent
 */
class SignupCest
{
    /**
     * Test successful registration flow.
     * 
     * @param AcceptanceTester $I
     * @return void
     */
    public function testSuccessfulRegistration(AcceptanceTester $I)
    {
        $I->wantTo('create a new account');
        $I->amOnPage('/register');
        $I->see('CMS SIGNUP');
        
        $I->fillField('First_name', 'John');
        $I->fillField('Last_name', 'Doe');
        $I->fillField('Email', 'newuser@example.com');
        $I->fillField('password', 'password123');
        $I->fillField('password_confirmation', 'password123');
        $I->click('CREATE ACCOUNT');
        
        $I->seeCurrentUrlEquals('/');
        $I->seeInDatabase('user', [
            'Email' => 'newuser@example.com',
            'First_name' => 'John',
            'Last_name' => 'Doe',
        ]);
    }

    /**
     * Test registration with duplicate email.
     * 
     * @param AcceptanceTester $I
     * @return void
     */
    public function testRegistrationWithDuplicateEmail(AcceptanceTester $I)
    {
        // Create existing user
        $I->haveInDatabase('user', [
            'First_name' => 'Existing',
            'Last_name' => 'User',
            'Email' => 'existing@example.com',
            'Password' => '$2y$04$VZWEgNZLHvZfBbXHrQmFi.xf4fH8gR/xQjpAiV3UvNB8CdxvH3HKu',
        ]);

        $I->wantTo('see error when registering with existing email');
        $I->amOnPage('/register');
        
        $I->fillField('First_name', 'John');
        $I->fillField('Last_name', 'Doe');
        $I->fillField('Email', 'existing@example.com');
        $I->fillField('password', 'password123');
        $I->fillField('password_confirmation', 'password123');
        $I->click('CREATE ACCOUNT');
        
        $I->seeCurrentUrlEquals('/register');
        $I->see('taken');
    }

    /**
     * Test registration with mismatched passwords.
     * 
     * @param AcceptanceTester $I
     * @return void
     */
    public function testRegistrationWithMismatchedPasswords(AcceptanceTester $I)
    {
        $I->wantTo('see error when passwords do not match');
        $I->amOnPage('/register');
        
        $I->fillField('First_name', 'John');
        $I->fillField('Last_name', 'Doe');
        $I->fillField('Email', 'test@example.com');
        $I->fillField('password', 'password123');
        $I->fillField('password_confirmation', 'differentpassword');
        $I->click('CREATE ACCOUNT');
        
        $I->seeCurrentUrlEquals('/register');
        $I->see('confirmation');
    }

    /**
     * Test signup page displays correctly.
     * 
     * @param AcceptanceTester $I
     * @return void
     */
    public function testSignupPageDisplays(AcceptanceTester $I)
    {
        $I->wantTo('see the signup page');
        $I->amOnPage('/register');
        
        $I->see('CMS SIGNUP');
        $I->seeElement('input[name="First_name"]');
        $I->seeElement('input[name="Last_name"]');
        $I->seeElement('input[name="Email"]');
        $I->seeElement('input[name="password"]');
        $I->seeElement('input[name="password_confirmation"]');
        $I->seeElement('button[type="submit"]');
        $I->see('Already have an account?');
    }
}
