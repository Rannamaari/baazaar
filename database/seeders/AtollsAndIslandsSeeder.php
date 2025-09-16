<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AtollsAndIslandsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $atollsAndIslands = [
            'Haa Alif (HA) – Thiladhunmathi Uthuruburi' => [
                'Baarah', 'Dhidhdhoo', 'Filladhoo', 'Hoarafushi', 'Ihavandhoo', 'Kelaa', 
                'Maarandhoo', 'Mulhadhoo', 'Muraidhoo', 'Thakandhoo', 'Thuraakunu', 
                'Uligan', 'Utheemu', 'Vashafaru'
            ],
            'Haa Dhaalu (HDh) – Thiladhunmathi Dhekunuburi' => [
                'Finey', 'Hanimaadhoo', 'Hirimaradhoo', 'Kulhudhuffushi', 'Kumundhoo', 
                'Kurinbi', 'Makunudhoo', 'Naivaadhoo', 'Nellaidhoo', 'Neykurendhoo', 
                'Nolhivaram', 'Nolhivaranfaru', 'Vaikaradhoo'
            ],
            'Shaviyani (Sh) – Miladhunmadulu Uthuruburi' => [
                'Bileffahi', 'Feevah', 'Feydhoo', 'Foakaidhoo', 'Funadhoo', 'Goidhoo', 
                'Kanditheemu', 'Komandoo', 'Lhaimagu', 'Maaungoodhoo', 'Maroshi', 
                'Milandhoo', 'Narudhoo', 'Noomaraa'
            ],
            'Noonu (N) – Miladhunmadulu Dhekunuburi' => [
                'Fodhdhoo', 'Henbadhoo', 'Holhudhoo', 'Kendhikolhudhoo', 'Kudafari', 
                'Landhoo', 'Lhohi', 'Maafaru', 'Maalhendhoo', 'Magoodhoo', 'Manadhoo', 
                'Miladhoo', 'Velidhoo'
            ],
            'Raa (R) – Maalhosmadulu Uthuruburi' => [
                'Alifushi', 'Angolhitheemu', 'Dhuvaafaru', 'Fainu', 'Hulhudhuffaaru', 
                'Inguraidhoo', 'Innamaadhoo', 'Kinolhas', 'Maakurathu', 'Maduvvari', 
                'Maamigili', 'Meedhoo', 'Rasgetheemu', 'Rasmaadhoo', 'Ungoofaaru', 'Vaadhoo'
            ],
            'Baa (B) – Maalhosmadulu Dhekunuburi' => [
                'Dharavandhoo', 'Dhonfanu', 'Eydhafushi', 'Fehendhoo', 'Fulhadhoo', 
                'Goidhoo', 'Hithaadhoo', 'Kamadhoo', 'Kendhoo', 'Kihaadhoo', 'Kudarikilu', 
                'Maalhos', 'Thulhaadhoo'
            ],
            'Lhaviyani (Lh) – Faadhippolhu' => [
                'Hinnavaru', 'Kurendhoo', 'Naifaru', 'Olhuvelifushi'
            ],
            'Kaafu (K) – Malé Atholhu' => [
                'Dhiffushi', 'Gaafaru', 'Gulhi', 'Guraidhoo', 'Himmafushi', 'Huraa', 
                'Kaashidhoo', 'Maafushi', 'Thulusdhoo'
            ],
            'Malé City' => [
                'Malé', 'Hulhumalé', 'Vilimalé'
            ],
            'Alif Alif (AA) – Ari Atholhu Uthuruburi' => [
                'Bodufolhudhoo', 'Feridhoo', 'Himandhoo', 'Maalhos', 'Mathiveri', 
                'Rasdhoo', 'Thoddoo', 'Ukulhas'
            ],
            'Alif Dhaal (ADh) – Ari Atholhu Dhekunuburi' => [
                'Dhangethi', 'Dhigurah', 'Didhdhoo', 'Fenfushi', 'Hangnaameedhoo', 
                'Kunburudhoo', 'Maamigili', 'Mahibadhoo', 'Mandhoo', 'Omadhoo'
            ],
            'Vaavu (V) – Felidhu Atholhu' => [
                'Felidhoo', 'Fulidhoo', 'Keyodhoo', 'Rakeedhoo', 'Thinadhoo'
            ],
            'Meemu (M) – Mulaku Atholhu' => [
                'Dhiggaru', 'Kolhufushi', 'Maduvvari', 'Mulah', 'Muli', 'Naalaafushi', 
                'Raimmandhoo', 'Veyvah'
            ],
            'Faafu (F) – Nilandhe Atholhu Uthuruburi' => [
                'Bileddhoo', 'Dharanboodhoo', 'Feeali', 'Magoodhoo', 'Nilandhoo'
            ],
            'Dhaalu (Dh) – Nilandhe Atholhu Dhekunuburi' => [
                'Bandidhoo', 'Hulhudheli', 'Kudahuvadhoo', 'Maaenboodhoo', 'Meedhoo', 'Rinbudhoo'
            ],
            'Thaa (Th) – Kolhumadulu' => [
                'Burunee', 'Dhiyamigili', 'Gaadhiffushi', 'Guraidhoo', 'Hirilandhoo', 
                'Kandoodhoo', 'Kinbidhoo', 'Madifushi', 'Omadhoo', 'Thimarafushi', 
                'Vandhoo', 'Veymandoo', 'Vilufushi'
            ],
            'Laamu (L) – Haddhunmathi' => [
                'Dhanbidhoo', 'Fonadhoo', 'Gaadhoo', 'Gan', 'Hithadhoo', 'Isdhoo', 
                'Kalaidhoo', 'Kunahandhoo', 'Maabaidhoo', 'Maamendhoo', 'Maavah', 
                'Mundoo', 'Maandhoo', 'Kadhdhoo'
            ],
            'Gaafu Alif (GA) – Huvadhu Atholhu Uthuruburi' => [
                'Dhaandhoo', 'Dhevvadhoo', 'Dhiyadhoo', 'Gemanafushi', 'Kanduhulhudhoo', 
                'Kolamaafushi', 'Kondey', 'Maamendhoo', 'Nilandhoo', 'Vilingili'
            ],
            'Gaafu Dhaalu (GDh) – Huvadhu Atholhu Dhekunuburi' => [
                'Fares-Maathodaa', 'Fiyoari', 'Gadhdhoo', 'Hoandeddhoo', 'Madaveli', 
                'Nadellaa', 'Rathafandhoo', 'Thinadhoo', 'Vaadhoo'
            ],
            'Gnaviyani (Gn) – Fuvahmulah City' => [
                'Fuvahmulah'
            ],
            'Seenu (S) – Addu City' => [
                'Hithadhoo', 'Maradhoo', 'Maradhoo-Feydhoo', 'Feydhoo', 'Meedhoo', 'Hulhudhoo'
            ]
        ];

        foreach ($atollsAndIslands as $atollName => $islands) {
            // Create the atoll
            $atollId = DB::table('atolls')->insertGetId([
                'name' => $atollName,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Create islands for this atoll
            $islandData = [];
            foreach ($islands as $island) {
                $islandData[] = [
                    'name' => $island,
                    'atoll_id' => $atollId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            DB::table('islands')->insert($islandData);
        }
    }
}
