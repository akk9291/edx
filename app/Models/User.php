<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'email',
        'phone',
        'password',
        'google_id',
        'is_admin',
        'role',
        'email_verification_token',
        'phone_verified_at',
        'email_verified_at',
        'gender',
        'date_of_birth',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
        ];
    }

    /**
     * Get user addresses
     */
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    /**
     * Get user cart items
     */
    public function cartItems()
    {
        return $this->hasMany(Cart::class);
    }

    /**
     * Get user orders
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get coupon usages
     */
    public function couponUsages()
    {
        return $this->hasMany(CouponUsage::class);
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->is_admin === true || $this->role === 'admin';
    }
}
