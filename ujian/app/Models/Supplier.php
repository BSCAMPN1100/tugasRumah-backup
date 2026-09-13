<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // ← TAMBAHKAN INI

class Supplier extends Model
{
    use HasFactory, SoftDeletes; // ← TAMBAHKAN SoftDeletes

    // protected $table = 'suppliers'; // BISA DIHAPUS (karena sudah sesuai konvensi)

    protected $fillable = ['nama'];

    public function pembelian()
    {
        return $this->hasMany(Pembelian::class);
    }
}