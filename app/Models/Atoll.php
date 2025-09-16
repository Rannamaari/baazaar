<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Atoll extends Model
{
    protected $fillable = [
        'name',
        'order',
    ];

    protected function casts(): array
    {
        return [
            'order' => 'integer',
        ];
    }

    public function islands(): HasMany
    {
        return $this->hasMany(Island::class);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}