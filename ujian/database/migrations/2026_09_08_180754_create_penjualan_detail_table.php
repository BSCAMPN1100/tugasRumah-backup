<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penjualan_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penjualan_id')->constrained('transaksi_penjualan')->onDelete('cascade');
            $table->foreignId('barang_id')->constrained('barang')->onDelete('restrict');
            
            // Snapshot untuk P12
            $table->string('nama_barang_snapshot', 255)->nullable();
            $table->string('satuan_snapshot', 50)->nullable();
            
            $table->integer('jumlah')->default(1);
            $table->decimal('harga_jual_saat_transaksi', 15, 2);
            $table->decimal('subtotal', 15, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penjualan_detail');
    }
};
