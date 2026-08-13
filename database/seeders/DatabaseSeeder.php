<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Setting;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Add Admin User
        User::firstOrCreate(
            ['email' => 'evanirmansyah123@gmail.com'],
            [
                'name' => 'Admin Setoran',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // Add Default Settings
        Setting::firstOrCreate(['key' => 'harga_email_khusus'], ['value' => '4300']);
        Setting::firstOrCreate(['key' => 'harga_email_bebas'], ['value' => '3300']);
    }
}
