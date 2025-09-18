<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@baazaar.mv'],
            [
                'name' => 'Admin User',
                'email' => 'admin@baazaar.mv',
                'phone' => '+960 7777777',
                'password' => Hash::make('admin123!'),
                'email_verified_at' => now(),
                'is_admin' => true,
            ]
        );
    }
}
