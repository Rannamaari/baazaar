<?php

declare(strict_types=1);

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser // implements MustVerifyEmail
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
        'is_admin',
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

    /**
     * Check if the user can access the Filament admin panel.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->is_admin;
    }

    /**
     * Check if the user is an admin.
     */
    public function isAdmin(): bool
    {
        return $this->is_admin;
    }
}
