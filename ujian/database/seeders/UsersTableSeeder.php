<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name'     => 'Admin Utama',
                'email'    => 'admin@catatrezekimu.com',
                'password' => Hash::make('admin123'),
                'role'     => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'     => 'Sales 1',
                'email'    => 'sales@catatrezekimu.com',
                'password' => Hash::make('sales123'),
                'role'     => 'sales',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
