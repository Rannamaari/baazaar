<?php

declare(strict_types=1);

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable // implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'email_verified_at',
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
        ];
    }

    /**
     * Get the orders for the user.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get the addresses for the user.
     */
    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }

    /**
     * Get the home addresses for the user.
     */
    public function homeAddresses(): HasMany
    {
        return $this->addresses()->home();
    }

    /**
     * Get the office addresses for the user.
     */
    public function officeAddresses(): HasMany
    {
        return $this->addresses()->office();
    }

    /**
     * Get the default address for the user.
     */
    public function defaultAddress(): HasMany
    {
        return $this->addresses()->default();
    }

    /**
     * Check if user has completed address setup.
     */
    public function hasAddresses(): bool
    {
        return $this->addresses()->count() > 0;
    }

    /**
     * Check if user has both home and office addresses.
     */
    public function hasCompleteAddresses(): bool
    {
        return $this->homeAddresses()->count() > 0 && $this->officeAddresses()->count() > 0;
    }

    /**
     * Get the pre-orders for the user.
     */
    public function preOrders(): HasMany
    {
        return $this->hasMany(PreOrder::class);
    }
}
