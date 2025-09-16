<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'status',
        'subtotal',
        'discount_total',
        'tax_total',
        'shipping_total',
        'grand_total',
        'currency',
        'payment_method',
        'payment_ref',
        'payment_status',
        'payment_slip_path',
        'delivery_address',
        'delivery_phone',
        'admin_notes',
        'payment_verified_at',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'discount_total' => 'decimal:2',
        'tax_total' => 'decimal:2',
        'shipping_total' => 'decimal:2',
        'grand_total' => 'decimal:2',
        'payment_verified_at' => 'datetime',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isPaymentPending(): bool
    {
        return $this->payment_status === 'pending';
    }

    public function isPaymentVerified(): bool
    {
        return $this->payment_status === 'verified';
    }

    public function isPaymentRejected(): bool
    {
        return $this->payment_status === 'rejected';
    }

    public function isCodOrder(): bool
    {
        return $this->payment_method === 'cash';
    }

    public function isBankTransferOrder(): bool
    {
        return $this->payment_method === 'bank_transfer';
    }

    public function hasPaymentSlip(): bool
    {
        return !empty($this->payment_slip_path);
    }
}
