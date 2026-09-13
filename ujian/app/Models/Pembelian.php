<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;

    protected $table = 'pembelian'; // <-- TAMBAHKAN INI

    protected $fillable = [
        'supplier_id',
        'nama_supplier_snapshot',
        'total_harga',
        'status'
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function detail()
    {
        return $this->hasMany(PembelianDetail::class);
    }
}