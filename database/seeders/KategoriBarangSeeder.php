<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriBarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('kategori_barangs')->insert([
            [
                'kode_kategori_barang' => 'KATEGORI-00001',
                'nama_kategori_barang' => 'Perlengkapan Ibadah',
                'created_by' => 1,
            ],
            [
                'kode_kategori_barang' => 'KATEGORI-00002',
                'nama_kategori_barang' => 'Peralatan Musik',
                'created_by' => 1,
            ],
            [
                'kode_kategori_barang' => 'KATEGORI-00003',
                'nama_kategori_barang' => 'Elektronik',
                'created_by' => 1,
            ],
            [
                'kode_kategori_barang' => 'KATEGORI-00004',
                'nama_kategori_barang' => 'Multimedia',
                'created_by' => 1,
            ],
            [
                'kode_kategori_barang' => 'KATEGORI-00005',
                'nama_kategori_barang' => 'Perabotan Gereja',
                'created_by' => 1,
            ],
        ]);
    }
}
