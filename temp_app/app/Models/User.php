<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Hash;
use App\Services\AuthManager;

/**
 * Class User
 * 
 * Represents a user in the system.
 * 
 * @property int $user_id The unique identifier for the user.
 * @property string $first_name The user's first name.
 * @property string $last_name The user's last name.
 * @property string $email The user's email address.
 * @property string $passwordHash The hashed password of the user.
 * 
 * @package App\Models
 * @author Agent
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'user';

    /**
     * The primary key associated with the table.
     * 
     * @var string
     */
    protected $primaryKey = 'User_id';

    /**
     * Indicates if the model should be timestamped.
     * 
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     * 
     * @var array<int, string>
     */
    protected $fillable = [
        'First_name',
        'Last_name',
        'Email',
        'Password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     * 
     * @var array<int, string>
     */
    protected $hidden = [
        'Password',
        'remember_token',
    ];

    /**
     * Get the password for the user.
     * 
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->Password;
    }

    /**
     * Get the attributes that should be cast.
     * 
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'Password' => 'hashed',
        ];
    }

    // Accessors for CamelCase properties

    /**
     * Get user_id attribute.
     * 
     * @return int
     */
    public function getUserIdAttribute()
    {
        return $this->attributes['User_id'];
    }

    /**
     * Get first_name attribute.
     * 
     * @return string
     */
    public function getFirstNameAttribute()
    {
        return $this->attributes['First_name'];
    }

    /**
     * Set first_name attribute.
     * 
     * @param string $value
     * @return void
     */
    public function setFirstNameAttribute($value)
    {
        $this->attributes['First_name'] = $value;
    }

    /**
     * Get last_name attribute.
     * 
     * @return string
     */
    public function getLastNameAttribute()
    {
        return $this->attributes['Last_name'];
    }

    /**
     * Set last_name attribute.
     * 
     * @param string $value
     * @return void
     */
    public function setLastNameAttribute($value)
    {
        $this->attributes['Last_name'] = $value;
    }

    /**
     * Get email attribute.
     * 
     * @return string
     */
    public function getEmailAttribute()
    {
        return $this->attributes['Email'];
    }

    /**
     * Set email attribute.
     * 
     * @param string $value
     * @return void
     */
    public function setEmailAttribute($value)
    {
        $this->attributes['Email'] = $value;
    }

    /**
     * Get passwordHash attribute.
     * 
     * @return string
     */
    public function getPasswordHashAttribute()
    {
        return $this->attributes['Password'];
    }

    /**
     * Set passwordHash attribute.
     * 
     * @param string $value
     * @return void
     */
    public function setPasswordHashAttribute($value)
    {
        $this->attributes['Password'] = $value;
    }

    // Methods from Class Diagram

    /**
     * Register a new user.
     * 
     * @param string $first_name
     * @param string $last_name
     * @param string $email
     * @param string $password
     * @return User
     */
    public function register(string $first_name, string $last_name, string $email, string $password): User
    {
        $this->First_name = $first_name;
        $this->Last_name = $last_name;
        $this->Email = $email;
        $this->Password = Hash::make($password);
        $this->save();

        return $this;
    }

    /**
     * Log in the user.
     * 
     * @param string $email
     * @param string $password
     * @return bool
     */
    public function login(string $email, string $password): bool
    {
        $authManager = new AuthManager();
        return $authManager->authenticate($email, $password);
    }

    /**
     * Log out the user.
     * 
     * @return void
     */
    public function logout(): void
    {
        $authManager = new AuthManager();
        $authManager->logoutUser();
    }

    /**
     * Update user profile details.
     * 
     * @param array $details
     * @return bool
     */
    public function updateProfile(array $details): bool
    {
        return $this->update($details);
    }
}
