<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('setoran_emails', function (Blueprint $table) {
            $table->boolean('is_read')->default(false)->after('admin_notes');
        });

        Schema::table('penarikan_saldo', function (Blueprint $table) {
            $table->boolean('is_read')->default(false)->after('admin_notes');
        });
    }

    public function down(): void
    {
        Schema::table('setoran_emails', function (Blueprint $table) {
            $table->dropColumn('is_read');
        });

        Schema::table('penarikan_saldo', function (Blueprint $table) {
            $table->dropColumn('is_read');
        });
    }
};
