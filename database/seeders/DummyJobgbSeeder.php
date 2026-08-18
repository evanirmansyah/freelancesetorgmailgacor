<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\SetoranEmail;
use App\Models\PenarikanSaldo;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DummyJobgbSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::updateOrCreate(
            ['email' => 'jobgb00@gmail.com'],
            [
                'name' => 'jobgb',
                'password' => Hash::make('anjay123'),
                'role' => 'user',
                'saldo' => 185000.00,
            ]
        );

        // Clear existing setoran & penarikan for this user
        SetoranEmail::where('user_id', $user->id)->delete();
        PenarikanSaldo::where('user_id', $user->id)->delete();

        // 1. Setoran Email Dummy (Approved, Pending, Rejected)
        $setorans = [
            [
                'category' => 'Email Khusus',
                'email_data' => "jobgb.vip01@gmail.com|Password123\njobgb.vip02@gmail.com|Password123\njobgb.vip03@gmail.com|Password123\njobgb.vip04@gmail.com|Password123\njobgb.vip05@gmail.com|Password123\njobgb.vip06@gmail.com|Password123\njobgb.vip07@gmail.com|Password123\njobgb.vip08@gmail.com|Password123\njobgb.vip09@gmail.com|Password123\njobgb.vip10@gmail.com|Password123",
                'total_emails' => 10,
                'reward_per_email' => 4300,
                'total_reward' => 43000,
                'status' => 'approved',
                'admin_notes' => null,
                'created_at' => Carbon::now()->subDays(3)->setHour(10)->setMinute(15),
                'updated_at' => Carbon::now()->subDays(3)->setHour(12)->setMinute(0),
            ],
            [
                'category' => 'Email Bebas',
                'email_data' => "userbebas101@gmail.com|passbebas1\nuserbebas102@gmail.com|passbebas2\nuserbebas103@gmail.com|passbebas3\nuserbebas104@gmail.com|passbebas4\nuserbebas105@gmail.com|passbebas5",
                'total_emails' => 20,
                'reward_per_email' => 3300,
                'total_reward' => 66000,
                'status' => 'approved',
                'admin_notes' => null,
                'created_at' => Carbon::now()->subDays(2)->setHour(14)->setMinute(30),
                'updated_at' => Carbon::now()->subDays(2)->setHour(16)->setMinute(10),
            ],
            [
                'category' => 'Email Khusus',
                'email_data' => "jobgb.indo01@gmail.com|PassIndo99\njobgb.indo02@gmail.com|PassIndo99\njobgb.indo03@gmail.com|PassIndo99",
                'total_emails' => 15,
                'reward_per_email' => 4300,
                'total_reward' => 64500,
                'status' => 'approved',
                'admin_notes' => null,
                'created_at' => Carbon::now()->subDays(2)->setHour(18)->setMinute(45),
                'updated_at' => Carbon::now()->subDays(2)->setHour(19)->setMinute(30),
            ],
            [
                'category' => 'Email Bebas',
                'email_data' => "akunbebas001@gmail.com|bebaspass1\nakunbebas002@gmail.com|bebaspass2",
                'total_emails' => 25,
                'reward_per_email' => 3300,
                'total_reward' => 82500,
                'status' => 'approved',
                'admin_notes' => null,
                'created_at' => Carbon::now()->subDays(1)->setHour(11)->setMinute(20),
                'updated_at' => Carbon::now()->subDays(1)->setHour(13)->setMinute(0),
            ],
            [
                'category' => 'Email Khusus',
                'email_data' => "jobgb.super01@gmail.com|SuperKey77\njobgb.super02@gmail.com|SuperKey77",
                'total_emails' => 18,
                'reward_per_email' => 4300,
                'total_reward' => 79000,
                'status' => 'approved',
                'admin_notes' => null,
                'created_at' => Carbon::now()->subDays(1)->setHour(16)->setMinute(10),
                'updated_at' => Carbon::now()->subDays(1)->setHour(17)->setMinute(40),
            ],
            [
                'category' => 'Email Khusus',
                'email_data' => "jobgb.pending01@gmail.com|PendingPass123\njobgb.pending02@gmail.com|PendingPass123",
                'total_emails' => 12,
                'reward_per_email' => 0,
                'total_reward' => 0,
                'status' => 'pending',
                'admin_notes' => null,
                'created_at' => Carbon::now()->subHours(5),
                'updated_at' => Carbon::now()->subHours(5),
            ],
            [
                'category' => 'Email Bebas',
                'email_data' => "bulkmail01@gmail.com|bulkpass123\nbulkmail02@gmail.com|bulkpass123",
                'total_emails' => 30,
                'reward_per_email' => 0,
                'total_reward' => 0,
                'status' => 'pending',
                'admin_notes' => null,
                'created_at' => Carbon::now()->subHours(1),
                'updated_at' => Carbon::now()->subHours(1),
            ],
            [
                'category' => 'Email Bebas',
                'email_data' => "invalidformat@gmail.com",
                'total_emails' => 5,
                'reward_per_email' => 0,
                'total_reward' => 0,
                'status' => 'rejected',
                'admin_notes' => 'Format akun tidak memiliki pemisah password (|)',
                'created_at' => Carbon::now()->subDays(3)->setHour(9)->setMinute(0),
                'updated_at' => Carbon::now()->subDays(3)->setHour(9)->setMinute(30),
            ],
        ];

        foreach ($setorans as $s) {
            $s['user_id'] = $user->id;
            SetoranEmail::create($s);
        }

        // 2. Riwayat Penarikan Saldo Dummy (Approved & Pending)
        $penarikans = [
            [
                'metode' => 'E-Wallet',
                'nama_bank_ewallet' => 'DANA',
                'nomor_rekening_hp' => '081234567890',
                'nama_pemilik' => 'Job GB Official',
                'jumlah' => 50000,
                'status' => 'approved',
                'admin_notes' => null,
                'created_at' => Carbon::now()->subDays(2)->setHour(20)->setMinute(0),
                'updated_at' => Carbon::now()->subDays(2)->setHour(20)->setMinute(15),
            ],
            [
                'metode' => 'Bank',
                'nama_bank_ewallet' => 'BCA',
                'nomor_rekening_hp' => '8820192831',
                'nama_pemilik' => 'Job GB Official',
                'jumlah' => 100000,
                'status' => 'approved',
                'admin_notes' => null,
                'created_at' => Carbon::now()->subDays(1)->setHour(19)->setMinute(30),
                'updated_at' => Carbon::now()->subDays(1)->setHour(19)->setMinute(45),
            ],
            [
                'metode' => 'E-Wallet',
                'nama_bank_ewallet' => 'GoPay',
                'nomor_rekening_hp' => '081234567890',
                'nama_pemilik' => 'Job GB Official',
                'jumlah' => 50000,
                'status' => 'pending',
                'admin_notes' => null,
                'created_at' => Carbon::now()->subHours(3),
                'updated_at' => Carbon::now()->subHours(3),
            ],
        ];

        foreach ($penarikans as $p) {
            $p['user_id'] = $user->id;
            PenarikanSaldo::create($p);
        }
    }
}
