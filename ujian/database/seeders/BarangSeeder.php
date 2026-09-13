<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Barang;

class BarangSeeder extends Seeder
{
    public function run(): void
    {
        Barang::create(['nama' => 'Beras 5kg', 'stok' => 10, 'harga_modal' => 50000, 'harga_jual' => 55000]);
        Barang::create(['nama' => 'Minyak Goreng 2L', 'stok' => 5, 'harga_modal' => 25000, 'harga_jual' => 28000]);
        Barang::create(['nama' => 'Gula 1kg', 'stok' => 8, 'harga_modal' => 12000, 'harga_jual' => 15000]);
    }
}
