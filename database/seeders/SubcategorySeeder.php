<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Database\Seeder;

class SubcategorySeeder extends Seeder
{
    public function run(): void
    {
        $subcategoriesData = [
            'Automotive & Parts' => ['Motorcycles', 'Car Accessories', 'Tires & Tubes', 'Oils & Lubricants', 'Batteries', 'Helmets & Safety Gear', 'Spare Parts', 'Tools'],
            
            'Beauty & Personal Care' => ['Skin Care', 'Hair Care', 'Makeup', 'Fragrances', 'Bath & Body', 'Men\'s Grooming', 'Tools & Accessories'],
            
            'Books & Stationery' => ['School Books', 'Notebooks', 'Pens & Writing Tools', 'Art Supplies', 'Office Supplies', 'Educational Toys'],
            
            'Cameras & Photography' => ['DSLR', 'Mirrorless', 'Lenses', 'Tripods', 'Lighting', 'Memory Cards', 'Action Cameras', 'Drones'],
            
            'Clothing & Fashion' => ['Men', 'Women', 'Kids', 'Shoes', 'Accessories', 'Bags & Wallets', 'Traditional Wear'],
            
            'Computers & Tablets' => ['Laptops', 'Desktops', 'Tablets', 'Monitors', 'Keyboards & Mice', 'Storage Devices', 'Networking'],
            
            'Electronics' => ['TVs', 'Audio Systems', 'Headphones', 'Power Banks', 'Wearables', 'Chargers', 'Small Appliances'],
            
            'Food & Drinks' => ['Snacks', 'Packaged Foods', 'Beverages', 'Tea & Coffee', 'Dairy', 'Frozen Food'],
            
            'Fresh Produce' => ['Fruits', 'Vegetables', 'Herbs', 'Organic', 'Local Produce'],
            
            'Furniture' => ['Living Room', 'Bedroom', 'Kitchen & Dining', 'Office', 'Outdoor', 'Storage', 'Kids\' Furniture'],
            
            'Gaming' => ['Consoles', 'Games (Physical/Digital)', 'Controllers', 'Gaming Chairs', 'Accessories'],
            
            'Gift & Recharge Cards' => ['Mobile Top-ups', 'Gaming Cards', 'Streaming Cards', 'Shopping Gift Cards'],
            
            'Health & Wellness' => ['Medicines (OTC)', 'Vitamins & Supplements', 'Fitness Gear', 'First Aid', 'Personal Hygiene'],
            
            'Home Decor' => ['Lighting', 'Wall Art', 'Rugs', 'Curtains', 'Clocks', 'Decorative Items'],
            
            'Home Essentials' => ['Cleaning Supplies', 'Storage & Organizers', 'Laundry', 'Tools', 'Small Appliances'],
            
            'Kitchen & Dining' => ['Cookware', 'Utensils', 'Appliances', 'Tableware', 'Storage'],
            
            'Made in Maldives' => ['Local Handicrafts', 'Food Products', 'Clothing', 'Souvenirs'],
            
            'Mobile Phones' => ['Smartphones', 'Feature Phones', 'Accessories', 'Cases & Covers', 'Chargers', 'Earphones'],
            
            'Others' => ['Miscellaneous', 'Seasonal', 'Festival Specials'],
            
            'Pet Care' => ['Food', 'Health', 'Accessories', 'Grooming'],
            
            'Plans & Licenses' => ['Software Licenses', 'Subscription Plans', 'Utilities', 'Insurance'],
            
            'Smart Devices' => ['Smartwatches', 'Smart Speakers', 'Smart Home', 'Wearables', 'Security'],
            
            'Toys & Games' => ['Outdoor Toys', 'Educational', 'Board Games', 'Dolls', 'Cars & Vehicles', 'Building Blocks'],
            
            'Travel & Luggage' => ['Suitcases', 'Backpacks', 'Duffel Bags', 'Travel Accessories'],
        ];

        foreach ($subcategoriesData as $categoryName => $subcategories) {
            $category = Category::where('name', $categoryName)->first();
            
            if ($category) {
                foreach ($subcategories as $index => $subcategoryName) {
                    Subcategory::create([
                        'category_id' => $category->id,
                        'name' => $subcategoryName,
                        'is_active' => true,
                        'sort_order' => $index + 1,
                    ]);
                }
            }
        }
    }
}