<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'is_active',
        'is_featured',
        'featured_rank',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'featured_rank' => 'integer',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function subcategories(): HasMany
    {
        return $this->hasMany(Subcategory::class);
    }

    public function brands(): BelongsToMany
    {
        return $this->belongsToMany(Brand::class, 'category_brand');
    }

    /**
     * Scope to get featured categories ordered by rank
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)
            ->whereNotNull('featured_rank')
            ->orderBy('featured_rank');
    }

    /**
     * Scope to get active categories
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get the featured categories count
     */
    public static function getFeaturedCount(): int
    {
        return static::where('is_featured', true)->count();
    }

    /**
     * Check if a featured rank is available
     */
    public static function isFeaturedRankAvailable(int $rank, ?int $excludeId = null): bool
    {
        $query = static::where('featured_rank', $rank);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->count() === 0;
    }
}
