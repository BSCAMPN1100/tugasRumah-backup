<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'display_name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
public static function generateDisplayName($name)
{
    $suffix = '';
    $counter = 2;

    // Cari user dengan display_name yang sama (termasuk yang sudah dihapus)
    while (User::withTrashed()->where('display_name', $name . $suffix)->exists()) {
        $suffix = ' (' . $counter . ')';
        $counter++;
    }

    return $name . $suffix;
}
public function penjualan()
{
    return $this->hasMany(Penjualan::class, 'user_id');
}
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
