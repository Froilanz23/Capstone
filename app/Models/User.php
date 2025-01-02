<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    // Role constants for better readability
    public const ROLE_ADMIN = 1;
    public const ROLE_ARTIST = 2;
    public const ROLE_CUSTOMER = 3;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'email', 'mobile', 'sex', 'birthdate', 'password', 'role', 'verified',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Define the relationship with the Order model.
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    /**
     * Check if the user is an Admin.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    /**
     * Check if the user is an Artist.
     *
     * @return bool
     */
    public function isArtist()
    {
        return $this->role === self::ROLE_ARTIST;
    }

    /**
     * Check if the user is a Customer.
     *
     * @return bool
     */
    public function isCustomer()
    {
        return $this->role === self::ROLE_CUSTOMER;
    }

    public function artist()
    {
        return $this->hasOne(Artist::class, 'user_id');
    }

    public function coupons()
    {
        return $this->belongsToMany(Coupon::class, 'coupon_user');
    }    

    
    
}
