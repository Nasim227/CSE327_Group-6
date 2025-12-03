<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    /**
     * Test the fullName method of the User model Returns the correct format
     */
    public function test_full_name_returns_the_correct_format()
    {
        $user = new User();
        $user->First_name = 'John';
        $user->Last_name = 'Smith';

        $this->assertEquals('John Smith', $user->fullName());
    }

    /**
     * Test the fullName method of the User model Returns the correct format with empty last name
     */
    public function test_full_name_returns_the_correct_format_with_empty_last_name()
    {
        $user = new User();
        $user->First_name = 'John';
        $user->Last_name = '';

        $this->assertEquals('John', $user->fullName());
    }

    /**
     * Test the fullName method of the User model Returns the correct format with trimming
     */
    public function test_full_name_returns_the_correct_format_with_trimming()
    {
        $user = new User();
        $user->First_name = ' Jane ';
        $user->Last_name = ' Doe ';

        $this->assertEquals('Jane Doe', $user->fullName());
    }

    /**
     * Test the getFirstNameAttribute accessor
     */
    public function test_get_first_name_attribute()
    {
        $user = new User();
        $user->setRawAttributes(['First_name' => 'Alice']);

        $this->assertEquals('Alice', $user->first_name);
    }

    /**
     * Test the getLastNameAttribute accessor
     */
    public function test_get_last_name_attribute()
    {
        $user = new User();
        $user->setRawAttributes(['Last_name' => 'Wonderland']);

        $this->assertEquals('Wonderland', $user->last_name);
    }

    /**
     * Test the getEmailAttribute accessor
     */
    public function test_get_email_attribute()
    {
        $user = new User();
        $user->setRawAttributes(['Email' => 'alice@example.com']);

        $this->assertEquals('alice@example.com', $user->email);
    }
}
