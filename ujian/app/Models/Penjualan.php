<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    use HasFactory;

    protected $table = 'transaksi_penjualan';

    protected $fillable = [
        'user_id',
        'total_harga',
        'keuntungan_kotor',
        'uang_dibayar',
        'kembalian',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function detail()
    {
        return $this->hasMany(PenjualanDetail::class, 'penjualan_id');
    }
}
