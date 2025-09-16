<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        // Create categories
        $electronics = Category::create([
            'name' => 'Electronics',
            'slug' => 'electronics',
            'is_active' => true,
        ]);

        $clothing = Category::create([
            'name' => 'Clothing',
            'slug' => 'clothing',
            'is_active' => true,
        ]);

        $home = Category::create([
            'name' => 'Home & Garden',
            'slug' => 'home-garden',
            'is_active' => true,
        ]);

        // Create products for Electronics
        $laptop = Product::factory()->create([
            'category_id' => $electronics->id,
            'name' => 'MacBook Pro 14"',
            'slug' => 'macbook-pro-14',
            'description' => 'Powerful laptop with M3 chip, perfect for professionals and creatives.',
            'price' => 280000, // 2800 MVR
            'compare_at_price' => 320000,
            'stock' => 5,
        ]);

        $phone = Product::factory()->create([
            'category_id' => $electronics->id,
            'name' => 'iPhone 15 Pro',
            'slug' => 'iphone-15-pro',
            'description' => 'Latest iPhone with titanium design and advanced camera system.',
            'price' => 180000, // 1800 MVR
            'stock' => 10,
        ]);

        // Create products for Clothing
        $tshirt = Product::factory()->create([
            'category_id' => $clothing->id,
            'name' => 'Cotton T-Shirt',
            'slug' => 'cotton-tshirt',
            'description' => 'Comfortable 100% cotton t-shirt in various colors.',
            'price' => 2500, // 25 MVR
            'stock' => 50,
        ]);

        // Create products for Home & Garden
        $chair = Product::factory()->create([
            'category_id' => $home->id,
            'name' => 'Ergonomic Office Chair',
            'slug' => 'ergonomic-office-chair',
            'description' => 'Comfortable office chair with lumbar support and adjustable height.',
            'price' => 15000, // 150 MVR
            'stock' => 15,
        ]);

        // Create sample product images
        ProductImage::create([
            'product_id' => $laptop->id,
            'path' => 'product-images/laptop-1.jpg',
            'position' => 1,
        ]);

        ProductImage::create([
            'product_id' => $laptop->id,
            'path' => 'product-images/laptop-2.jpg',
            'position' => 2,
        ]);

        ProductImage::create([
            'product_id' => $phone->id,
            'path' => 'product-images/phone-1.jpg',
            'position' => 1,
        ]);

        ProductImage::create([
            'product_id' => $tshirt->id,
            'path' => 'product-images/tshirt-1.jpg',
            'position' => 1,
        ]);

        // Create additional random products
        Product::factory(15)->create([
            'category_id' => $electronics->id,
        ]);

        Product::factory(20)->create([
            'category_id' => $clothing->id,
        ]);

        Product::factory(10)->create([
            'category_id' => $home->id,
        ]);
    }
}
