<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembelianDetail extends Model
{
    use HasFactory;

    protected $table = 'pembelian_detail'; // <-- TAMBAHKAN INI
protected $fillable = [
    'pembelian_id',
    'barang_id',
    'nama_barang_snapshot',   // ← HARUS ADA
    'satuan_snapshot',        // ← HARUS ADA
    'jumlah',
    'harga_modal_saat_beli',
    'subtotal'
];
    public function pembelian()
    {
        return $this->belongsTo(Pembelian::class);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}