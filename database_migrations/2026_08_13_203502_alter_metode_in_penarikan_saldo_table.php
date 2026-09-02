<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Updated to be database-agnostic (PostgreSQL, MySQL, SQLite compatible)
     */
    public function up(): void
    {
        $driver = DB::connection()->getDriverName();

        if ($driver === 'mysql' || $driver === 'mariadb') {
            DB::statement("ALTER TABLE penarikan_saldo MODIFY COLUMN metode VARCHAR(255)");
        } elseif ($driver === 'pgsql') {
            DB::statement("ALTER TABLE penarikan_saldo ALTER COLUMN metode TYPE VARCHAR(255)");
        }
        // sqlite: column is already VARCHAR, no change needed
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $driver = DB::connection()->getDriverName();
        if ($driver === 'mysql' || $driver === 'mariadb') {
            DB::statement("ALTER TABLE penarikan_saldo MODIFY COLUMN metode ENUM('DANA', 'Bank')");
        }
    }
};
