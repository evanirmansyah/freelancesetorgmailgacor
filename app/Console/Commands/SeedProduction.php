<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Setting;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class SeedProduction extends Command
{
    protected $signature = 'seed:production';
    protected $description = 'Seed initial production data';

    public function handle(): void
    {
        $this->info('Seeding admin user...');
        User::firstOrCreate(
            ['email' => 'evanirmansyah123@gmail.com'],
            [
                'name'     => 'Admin Setoran',
                'password' => Hash::make('password'),
                'role'     => 'admin',
            ]
        );

        $this->info('Seeding settings...');
        Setting::firstOrCreate(['key' => 'harga_email_khusus'], ['value' => '4300']);
        Setting::firstOrCreate(['key' => 'harga_email_bebas'],  ['value' => '3300']);

        $this->info('Done!');
    }
}
