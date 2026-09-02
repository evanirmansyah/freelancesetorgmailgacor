<?php

use Illuminate\Support\Facades\Route;

Route::get('/migrate-db', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        
        \App\Models\User::firstOrCreate(
            ['email' => 'evanirmansyah123@gmail.com'],
            [
                'name' => 'Admin Setoran',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'role' => 'admin',
            ]
        );

        \App\Models\Setting::firstOrCreate(['key' => 'harga_email_khusus'], ['value' => '4300']);
        \App\Models\Setting::firstOrCreate(['key' => 'harga_email_bebas'], ['value' => '3300']);

        return 'Database migrated and seeded successfully! Please delete this route afterwards.';
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});
