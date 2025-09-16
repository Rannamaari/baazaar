<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'subcategory_id',
        'brand_id',
        'name',
        'slug',
        'description',
        'stock',
        'price',
        'compare_at_price',
        'is_active',
    ];

    protected $casts = [
        'stock' => 'integer',
        'price' => 'decimal:2',
        'compare_at_price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('position');
    }

    public function featuredImage(): ?ProductImage
    {
        return $this->images()->first();
    }

    public function getFeaturedImageUrlAttribute(): ?string
    {
        $featuredImage = $this->featuredImage();
        return $featuredImage ? asset('storage/' . $featuredImage->path) : null;
    }

    public function getImagePathAttribute(): ?string
    {
        $featuredImage = $this->featuredImage();
        return $featuredImage?->path;
    }
}
