<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Trim semua nama yang ada (spasi awal/akhir)
        DB::statement('UPDATE barang SET nama = TRIM(nama) WHERE nama != TRIM(nama)');

        // Cek duplikat setelah trim (case-insensitive)
        $duplicates = DB::select('
            SELECT nama, COUNT(*) as count
            FROM barang
            GROUP BY nama
            HAVING COUNT(*) > 1
        ');

        if (count($duplicates) > 0) {
            $names = implode(', ', array_column($duplicates, 'nama'));
            throw new \Exception("Terdapat duplikat nama barang setelah trim: {$names}. Harap perbaiki secara manual.");
        }

        // Tambahkan unique index
        Schema::table('barang', function (Blueprint $table) {
            $table->unique('nama');
        });
    }

    public function down(): void
    {
        Schema::table('barang', function (Blueprint $table) {
            $table->dropUnique('barang_nama_unique');
        });
    }
};
