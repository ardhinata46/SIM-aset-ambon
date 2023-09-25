<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('profils')->insert([
            [
                'nama_aplikasi' => 'SIMA STTII Ambon',
                'nama_organisasi' => 'STTII Ambon',
                'alamat' => 'Jl Raya Sisingamangaraja - Waitatiri - Suli',
                'logo' => 'logo.jpg',
                'email' => 'admin@sttii-ambon.ac.id',
                'updated_by' => 1,

            ],
        ]);
    }
}
