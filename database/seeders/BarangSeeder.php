<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('barangs')->insert([
            [
                'id_kategori_barang' => 5,
                'kode_barang' => 'BARANG-00001',
                'nama_barang' => 'Meja',
                'created_by' => 1,
            ],
            [
                'id_kategori_barang' => 5,
                'kode_barang' => 'BARANG-00002',
                'nama_barang' => 'Kursi',
                'created_by' => 1,
            ],
            [
                'id_kategori_barang' => 2,
                'kode_barang' => 'BARANG-00003',
                'nama_barang' => 'Keyboard',
                'created_by' => 1,
            ],
            [
                'id_kategori_barang' => 2,
                'kode_barang' => 'BARANG-00004',
                'nama_barang' => 'Gitar',
                'created_by' => 1,
            ],
            [
                'id_kategori_barang' => 4,
                'kode_barang' => 'BARANG-00005',
                'nama_barang' => 'Komputer',
                'created_by' => 1,
            ],
        ]);
    }
}
