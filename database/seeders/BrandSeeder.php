<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $brandsData = [
            // Automotive & Parts
            'Automotive & Parts' => ['Honda', 'Yamaha', 'Suzuki', 'Bajaj', 'Toyota', 'Castrol', 'Mobil', 'Bosch', 'NGK', 'Michelin', 'Other Brands'],
            
            // Beauty & Personal Care
            'Beauty & Personal Care' => ['L\'Oréal', 'Nivea', 'Garnier', 'Maybelline', 'MAC', 'Olay', 'Himalaya', 'Dove', 'Axe', 'Other Brands'],
            
            // Books & Stationery
            'Books & Stationery' => ['Staedtler', 'Faber-Castell', 'Pilot', 'Parker', 'Oxford', 'Classmate', 'Maped', 'Other Brands'],
            
            // Cameras & Photography
            'Cameras & Photography' => ['Canon', 'Nikon', 'Sony', 'GoPro', 'DJI', 'Fujifilm', 'Sandisk', 'Manfrotto', 'Other Brands'],
            
            // Clothing & Fashion
            'Clothing & Fashion' => ['Adidas', 'Nike', 'Zara', 'H&M', 'Mango', 'Levis', 'Puma', 'Gucci', 'Other Brands'],
            
            // Computers & Tablets
            'Computers & Tablets' => ['Apple', 'Dell', 'HP', 'Lenovo', 'Asus', 'Acer', 'Microsoft', 'Logitech', 'Seagate', 'WD', 'Other Brands'],
            
            // Electronics
            'Electronics' => ['Samsung', 'Sony', 'LG', 'JBL', 'Anker', 'Bose', 'Philips', 'Panasonic', 'Xiaomi', 'Other Brands'],
            
            // Food & Drinks
            'Food & Drinks' => ['Nestlé', 'Coca-Cola', 'Pepsi', 'Red Bull', 'Kraft', 'Maliban', 'Milo', 'Nescafé', 'Other Brands'],
            
            // Fresh Produce
            'Fresh Produce' => ['Local farms', 'Imported', 'Other Brands'],
            
            // Furniture
            'Furniture' => ['IKEA', 'Nilkamal', 'Home Centre', 'Maldivian carpenters', 'Other Brands'],
            
            // Gaming
            'Gaming' => ['Sony PlayStation', 'Xbox', 'Nintendo', 'Razer', 'MSI', 'Logitech G', 'SteelSeries', 'Other Brands'],
            
            // Gift & Recharge Cards
            'Gift & Recharge Cards' => ['PlayStation', 'Xbox', 'Apple Store', 'Google Play', 'Netflix', 'Amazon', 'Other Brands'],
            
            // Health & Wellness
            'Health & Wellness' => ['Other Brands'],
            
            // Home Decor
            'Home Decor' => ['IKEA', 'Home Centre', 'Philips', 'Local Handicrafts', 'Other Brands'],
            
            // Home Essentials
            'Home Essentials' => ['Dettol', 'Harpic', 'Mr. Muscle', '3M', 'Clorox', 'Vileda', 'Other Brands'],
            
            // Kitchen & Dining
            'Kitchen & Dining' => ['Other Brands'],
            
            // Made in Maldives
            'Made in Maldives' => ['Other Brands'],
            
            // Mobile Phones
            'Mobile Phones' => ['Apple', 'Samsung', 'Huawei', 'Xiaomi', 'Oppo', 'Vivo', 'OnePlus', 'Realme', 'Nokia', 'Other Brands'],
            
            // Others
            'Others' => ['Other Brands'],
            
            // Pet Care
            'Pet Care' => ['Other Brands'],
            
            // Plans & Licenses
            'Plans & Licenses' => ['Microsoft', 'Adobe', 'Avast', 'Kaspersky', 'Spotify', 'Netflix', 'Other Brands'],
            
            // Smart Devices
            'Smart Devices' => ['Apple', 'Samsung', 'Google Nest', 'Amazon Alexa', 'Xiaomi', 'TP-Link', 'Ring', 'Other Brands'],
            
            // Toys & Games
            'Toys & Games' => ['Lego', 'Mattel', 'Hasbro', 'Nerf', 'Barbie', 'Hot Wheels', 'Fisher-Price', 'Other Brands'],
            
            // Travel & Luggage
            'Travel & Luggage' => ['Samsonite', 'American Tourister', 'Kipling', 'Skybags', 'VIP', 'Other Brands'],
        ];

        // Create all unique brands first
        $uniqueBrands = [];
        foreach ($brandsData as $brands) {
            foreach ($brands as $brand) {
                $uniqueBrands[$brand] = $brand;
            }
        }

        $createdBrands = [];
        foreach ($uniqueBrands as $brandName) {
            $brand = Brand::create([
                'name' => $brandName,
                'is_active' => true,
            ]);
            $createdBrands[$brandName] = $brand;
        }

        // Now attach brands to categories
        foreach ($brandsData as $categoryName => $brands) {
            $category = Category::where('name', $categoryName)->first();
            if ($category) {
                foreach ($brands as $brandName) {
                    if (isset($createdBrands[$brandName])) {
                        $category->brands()->attach($createdBrands[$brandName]->id);
                    }
                }
            }
        }
    }
}