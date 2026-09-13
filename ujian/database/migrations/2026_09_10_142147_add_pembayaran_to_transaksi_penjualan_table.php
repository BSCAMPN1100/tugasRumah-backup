<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transaksi_penjualan', function (Blueprint $table) {
            $table->decimal('uang_dibayar', 15, 2)->default(0)->after('keuntungan_kotor');
            $table->decimal('kembalian', 15, 2)->default(0)->after('uang_dibayar');
        });
    }

    public function down(): void
    {
        Schema::table('transaksi_penjualan', function (Blueprint $table) {
            $table->dropColumn(['uang_dibayar', 'kembalian']);
        });
    }
};
