<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class FeaturedCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create or update featured categories
        $featuredCategories = [
            [
                'name' => 'Electronics',
                'slug' => 'electronics',
                'description' => 'Latest gadgets, smartphones, laptops, and electronic accessories',
                'icon' => '📱',
                'is_featured' => true,
                'featured_rank' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Fashion',
                'slug' => 'fashion',
                'description' => 'Trendy clothing, shoes, and accessories for all seasons',
                'icon' => '👕',
                'is_featured' => true,
                'featured_rank' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Home & Garden',
                'slug' => 'home-garden',
                'description' => 'Everything for your home and garden needs',
                'icon' => '🏠',
                'is_featured' => true,
                'featured_rank' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($featuredCategories as $categoryData) {
            Category::updateOrCreate(
                ['slug' => $categoryData['slug']],
                $categoryData
            );
        }

        // Create some additional regular categories
        $regularCategories = [
            [
                'name' => 'Books',
                'slug' => 'books',
                'description' => 'Books for all ages and interests',
                'icon' => '📚',
                'is_featured' => false,
                'featured_rank' => null,
                'is_active' => true,
            ],
            [
                'name' => 'Sports',
                'slug' => 'sports',
                'description' => 'Sports equipment and fitness gear',
                'icon' => '⚽',
                'is_featured' => false,
                'featured_rank' => null,
                'is_active' => true,
            ],
            [
                'name' => 'Beauty',
                'slug' => 'beauty',
                'description' => 'Beauty and personal care products',
                'icon' => '💄',
                'is_featured' => false,
                'featured_rank' => null,
                'is_active' => true,
            ],
            [
                'name' => 'Toys',
                'slug' => 'toys',
                'description' => 'Toys and games for children',
                'icon' => '🧸',
                'is_featured' => false,
                'featured_rank' => null,
                'is_active' => true,
            ],
            [
                'name' => 'Automotive',
                'slug' => 'automotive',
                'description' => 'Car parts and automotive accessories',
                'icon' => '🚗',
                'is_featured' => false,
                'featured_rank' => null,
                'is_active' => true,
            ],
        ];

        foreach ($regularCategories as $categoryData) {
            Category::updateOrCreate(
                ['slug' => $categoryData['slug']],
                $categoryData
            );
        }
    }
}
