<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'label',
        'street_address',
        'road_name',
        'island',
        'atoll',
        'postal_code',
        'additional_notes',
        'is_default',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    /**
     * Get the user that owns the address.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope for home addresses.
     */
    public function scopeHome($query)
    {
        return $query->where('type', 'home');
    }

    /**
     * Scope for office addresses.
     */
    public function scopeOffice($query)
    {
        return $query->where('type', 'office');
    }

    /**
     * Scope for default addresses.
     */
    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }

    /**
     * Get the full address as a formatted string.
     */
    public function getFullAddressAttribute(): string
    {
        $parts = [
            $this->street_address,
            $this->road_name,
            $this->island,
            $this->atoll,
        ];

        return implode(', ', array_filter($parts));
    }

    /**
     * Get the display name for the address.
     */
    public function getDisplayNameAttribute(): string
    {
        if ($this->label) {
            return $this->label;
        }

        return ucfirst($this->type).' - '.$this->island;
    }
}
