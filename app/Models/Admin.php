<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Admin Model
 * 
 * Represents administrative staff accounts in the system.
 * Completely separate from regular User accounts with its own authentication guard.
 * 
 * @property int $id Unique identifier for the admin
 * @property string $name Full name of the admin
 * @property string $email Email address (unique, used for login)
 * @property string $password Hashed password
 * @property string|null $remember_token Token for "remember me" functionality
 * @property \Carbon\Carbon $created_at Timestamp when admin was created
 * @property \Carbon\Carbon $updated_at Timestamp when admin was last updated
 * 
 * @package App\Models
 */

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The authentication guard this model uses
     * 
     * @var string
     */
    protected $guard = 'admin';

    /**
     * Mass-assignable attributes
     * These can be set via Admin::create() or $admin->fill()
     * 
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * Attributes hidden from JSON serialization
     * Prevents passwords and tokens from being exposed in API responses
     * 
     * @var array<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast
     * Laravel automatically hashes the password when set
     * 
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }
}
