<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class SuperadminSeeder extends Seeder
{
    public function run()
    {
    DB::table('superadmin')
        ->where('username', 'superadmin') // atau where('id', 1)
        ->update([
            'password' => Hash::make('lesti2914') // ← ganti dengan password baru yang kamu mau
        ]);
    }
}
