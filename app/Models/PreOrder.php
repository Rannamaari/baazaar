<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PreOrder extends Model
{
    protected $fillable = [
        'user_id',
        'product_name',
        'brand',
        'product_url',
        'additional_details',
        'status',
        'admin_notes',
        'estimated_price',
        'final_price',
        'sourced_at',
    ];

    protected function casts(): array
    {
        return [
            'estimated_price' => 'decimal:2',
            'final_price' => 'decimal:2',
            'sourced_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending' => 'Pending Review',
            'reviewing' => 'Under Review',
            'sourcing' => 'Being Sourced',
            'sourced' => 'Item Sourced',
            'cancelled' => 'Cancelled',
            'completed' => 'Completed',
            default => ucfirst($this->status)
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending' => 'warning',
            'reviewing' => 'info',
            'sourcing' => 'primary',
            'sourced' => 'success',
            'cancelled' => 'danger',
            'completed' => 'success',
            default => 'secondary'
        };
    }
}
