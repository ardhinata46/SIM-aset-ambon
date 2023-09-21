<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenggunaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('penggunas')->insert([
            [
                'nama_pengguna' => 'Super Admin',
                'role' => 'superadmin',
                'jk' => 'l',
                'email' => 'superadmin@gmail.com',
                'password' => bcrypt('123456'),
                'alamat' => 'Jl. Contoh Alamat',
                'kontak' => '088776650987',
                'status' => 1,
                'foto' => 'default.jpg',
            ],
            [
                'nama_pengguna' => 'Admin User',
                'role' => 'admin',
                'jk' => 'l',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('123456'),
                'alamat' => 'Jl. Contoh Alamat',
                'kontak' => '088776655445',
                'status' => 1,
                'foto' => 'default.jpg',
            ],
        ]);
    }
}
