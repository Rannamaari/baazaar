<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Island extends Model
{
    protected $fillable = [
        'atoll_id',
        'name',
    ];

    public function atoll(): BelongsTo
    {
        return $this->belongsTo(Atoll::class);
    }

    public function scopeForAtoll($query, $atollId)
    {
        return $query->where('atoll_id', $atollId);
    }
}