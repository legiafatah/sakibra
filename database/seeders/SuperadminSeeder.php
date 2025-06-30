<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class SuperadminSeeder extends Seeder
{
    public function run()
    {
        DB::table('superadmin')->insert([
            'nama' => 'Super Admin',
            'jk' => 'L',
            'no_wa' => '08123456789',
            'username' => 'superadmin',
            'password' => Hash::make('password123'),
            'status' => 1
        ]);
    }
}
