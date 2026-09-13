<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pembelian_detail', function (Blueprint $table) {
            $table->string('nama_barang_snapshot', 255)->nullable()->after('barang_id');
            $table->string('satuan_snapshot', 50)->nullable()->after('nama_barang_snapshot');
        });
    }

    public function down(): void
    {
        Schema::table('pembelian_detail', function (Blueprint $table) {
            $table->dropColumn(['nama_barang_snapshot', 'satuan_snapshot']);
        });
    }
};
