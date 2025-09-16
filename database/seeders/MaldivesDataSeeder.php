<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaldivesDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create atolls table if it doesn't exist
        if (! DB::getSchemaBuilder()->hasTable('atolls')) {
            DB::statement('
                CREATE TABLE atolls (
                    id SERIAL PRIMARY KEY,
                    name VARCHAR(255) NOT NULL,
                    code VARCHAR(10) NOT NULL,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                )
            ');
        }

        // Create islands table if it doesn't exist
        if (! DB::getSchemaBuilder()->hasTable('islands')) {
            DB::statement('
                CREATE TABLE islands (
                    id SERIAL PRIMARY KEY,
                    name VARCHAR(255) NOT NULL,
                    atoll_id INTEGER REFERENCES atolls(id),
                    is_inhabited BOOLEAN DEFAULT true,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                )
            ');
        }

        // Clear existing data
        DB::table('islands')->delete();
        DB::table('atolls')->delete();

        // Maldives Atolls Data
        $atolls = [
            ['name' => 'Haa Alif', 'code' => 'HA'],
            ['name' => 'Haa Dhaalu', 'code' => 'HDh'],
            ['name' => 'Shaviyani', 'code' => 'Sh'],
            ['name' => 'Noonu', 'code' => 'N'],
            ['name' => 'Raa', 'code' => 'R'],
            ['name' => 'Baa', 'code' => 'B'],
            ['name' => 'Lhaviyani', 'code' => 'Lh'],
            ['name' => 'Kaafu', 'code' => 'K'],
            ['name' => 'Alifu Alifu', 'code' => 'AA'],
            ['name' => 'Alifu Dhaalu', 'code' => 'ADh'],
            ['name' => 'Vaavu', 'code' => 'V'],
            ['name' => 'Meemu', 'code' => 'M'],
            ['name' => 'Faafu', 'code' => 'F'],
            ['name' => 'Dhaalu', 'code' => 'Dh'],
            ['name' => 'Thaa', 'code' => 'Th'],
            ['name' => 'Laamu', 'code' => 'L'],
            ['name' => 'Gaafu Alifu', 'code' => 'GA'],
            ['name' => 'Gaafu Dhaalu', 'code' => 'GDh'],
            ['name' => 'Gnaviyani', 'code' => 'Gn'],
            ['name' => 'Seenu', 'code' => 'S'],
        ];

        // Insert atolls
        foreach ($atolls as $atoll) {
            DB::table('atolls')->insert([
                'name' => $atoll['name'],
                'code' => $atoll['code'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Get atoll IDs for reference
        $atollIds = DB::table('atolls')->pluck('id', 'name')->toArray();

        // Major inhabited islands for each atoll
        $islands = [
            // Haa Alif
            'Haa Alif' => ['Dhidhdhoo', 'Hoarafushi', 'Ihavandhoo', 'Kelaa', 'Kulhudhuffushi', 'Kumundhoo', 'Kurinbi', 'Maarandhoo', 'Muraidhoo', 'Thakandhoo', 'Thuraakunu', 'Uligan', 'Utheemu', 'Vashafaru'],

            // Haa Dhaalu
            'Haa Dhaalu' => ['Finey', 'Hanimaadhoo', 'Hirimaradhoo', 'Kulhudhuffushi', 'Kumundhoo', 'Kurinbi', 'Maarandhoo', 'Muraidhoo', 'Neykurendhoo', 'Nolhivaram', 'Nolhivaranfaru', 'Thakandhoo', 'Thuraakunu', 'Uligan', 'Utheemu', 'Vashafaru'],

            // Shaviyani
            'Shaviyani' => ['Bilehdhoo', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah'],

            // Noonu
            'Noonu' => ['Holhudhoo', 'Kendhikolhudhoo', 'Kudafaree', 'Landhoo', 'Lhohi', 'Maafaru', 'Maalhendhoo', 'Magoodhoo', 'Manadhoo', 'Miladhoo', 'Velidhoo'],

            // Raa
            'Raa' => ['Alifushi', 'Angolhitheemu', 'Dhuvaafaru', 'Fainu', 'Hulhudhuffaaru', 'Inguraidhoo', 'Innamaadhoo', 'Kandholhudhoo', 'Kinolhas', 'Maakurathu', 'Maduvvaree', 'Meedhoo', 'Rasgetheemu', 'Rasmaadhoo', 'Ungoofaaru', 'Vaadhoo'],

            // Baa
            'Baa' => ['Dharavandhoo', 'Dhonfanu', 'Eydhafushi', 'Fehendhoo', 'Fulhadhoo', 'Goidhoo', 'Hithaadhoo', 'Kamadhoo', 'Kendhoo', 'Kihaadhoo', 'Kudarikilu', 'Maalhos', 'Thulhaadhoo'],

            // Lhaviyani
            'Lhaviyani' => ['Hinnavaru', 'Kurendhoo', 'Maafilaafushi', 'Naifaru', 'Olhuvelifushi'],

            // Kaafu (Malé Atoll)
            'Kaafu' => ['Malé', 'Hulhumalé', 'Vilimalé', 'Thulusdhoo', 'Himmafushi', 'Gulhi', 'Maafushi', 'Dhiffushi', 'Thoddoo', 'Rasdhoo', 'Thoddoo', 'Guraidhoo', 'Gulhi', 'Himmafushi', 'Huraa', 'Kaashidhoo', 'Thulusdhoo'],

            // Alifu Alifu
            'Alifu Alifu' => ['Bodufolhudhoo', 'Bodufolhudhoo', 'Feridhoo', 'Himandhoo', 'Hulhudheli', 'Kunburudhoo', 'Maalhos', 'Mathiveri', 'Rasdhoo', 'Thoddoo', 'Utheemu', 'Vashafaru'],

            // Alifu Dhaalu
            'Alifu Dhaalu' => ['Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah'],

            // Vaavu
            'Vaavu' => ['Felidhoo', 'Fulidhoo', 'Keyodhoo', 'Rakeedhoo', 'Thinadhoo'],

            // Meemu
            'Meemu' => ['Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah'],

            // Faafu
            'Faafu' => ['Bilehdhoo', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah'],

            // Dhaalu
            'Dhaalu' => ['Bandidhoo', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah'],

            // Thaa
            'Thaa' => ['Dhiyamigili', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah'],

            // Laamu
            'Laamu' => ['Dhanbidhoo', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah'],

            // Gaafu Alifu
            'Gaafu Alifu' => ['Dhevvadhoo', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah'],

            // Gaafu Dhaalu
            'Gaafu Dhaalu' => ['Faresmaathodaa', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah', 'Dhigurah'],

            // Gnaviyani
            'Gnaviyani' => ['Fuvahmulah'],

            // Seenu (Addu)
            'Seenu' => ['Hithadhoo', 'Maradhoo', 'Feydhoo', 'Hulhudhoo', 'Meedhoo', 'Maradhoo-Feydhoo'],
        ];

        // Insert islands
        foreach ($islands as $atollName => $islandList) {
            $atollId = $atollIds[$atollName] ?? null;
            if ($atollId) {
                foreach ($islandList as $islandName) {
                    DB::table('islands')->insert([
                        'name' => $islandName,
                        'atoll_id' => $atollId,
                        'is_inhabited' => true,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}
