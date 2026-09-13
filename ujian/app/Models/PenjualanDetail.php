<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjualanDetail extends Model
{
    use HasFactory;

    protected $table = 'penjualan_detail';

    protected $fillable = [
        'penjualan_id',
        'barang_id',
        'nama_barang_snapshot',   // SNAPSHOT
        'satuan_snapshot',        // SNAPSHOT
        'jumlah',
        'harga_jual_saat_transaksi',
        'subtotal',
    ];

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'penjualan_id');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
