<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Automotive & Parts', 'is_featured' => true],
            ['name' => 'Beauty & Personal Care', 'is_featured' => false],
            ['name' => 'Books & Stationery', 'is_featured' => false],
            ['name' => 'Cameras & Photography', 'is_featured' => false],
            ['name' => 'Clothing & Fashion', 'is_featured' => false],
            ['name' => 'Computers & Tablets', 'is_featured' => false],
            ['name' => 'Electronics', 'is_featured' => false],
            ['name' => 'Food & Drinks', 'is_featured' => false],
            ['name' => 'Fresh Produce', 'is_featured' => false],
            ['name' => 'Furniture', 'is_featured' => false],
            ['name' => 'Gaming', 'is_featured' => false],
            ['name' => 'Gift & Recharge Cards', 'is_featured' => true],
            ['name' => 'Health & Wellness', 'is_featured' => false],
            ['name' => 'Home Decor', 'is_featured' => false],
            ['name' => 'Home Essentials', 'is_featured' => false],
            ['name' => 'Kitchen & Dining', 'is_featured' => false],
            ['name' => 'Made in Maldives', 'is_featured' => true],
            ['name' => 'Mobile Phones', 'is_featured' => false],
            ['name' => 'Others', 'is_featured' => false],
            ['name' => 'Pet Care', 'is_featured' => false],
            ['name' => 'Plans & Licenses', 'is_featured' => false],
            ['name' => 'Smart Devices', 'is_featured' => false],
            ['name' => 'Toys & Games', 'is_featured' => false],
            ['name' => 'Travel & Luggage', 'is_featured' => false],
        ];

        foreach ($categories as $categoryData) {
            Category::create([
                'name' => $categoryData['name'],
                'slug' => \Str::slug($categoryData['name']),
                'is_active' => true,
                'is_featured' => $categoryData['is_featured'],
            ]);
        }
    }
}