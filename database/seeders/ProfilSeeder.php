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
                'nama_aplikasi' => 'SINV GPIBI AA',
                'nama_organisasi' => 'Gereja Perhimpunan Injili Baptis Indonesia "AMANAT AGUNG" Kalasan',
                'alamat' => 'Jl. Cupuwatu II No.07/02, Cupuwatu I, Purwomartani, Kec. Kalasan, Kabupaten Sleman, Daerah Istimewa Yogyakarta 55571',
                'logo' => 'logo.jpg',
                'email' => 'email@gmail.com',
                'updated_by' => 1,

            ],
        ]);
    }
}
