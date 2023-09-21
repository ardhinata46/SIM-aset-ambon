<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriBarang extends Model
{
    use HasFactory;
    protected $table = "kategori_barangs";
    protected $primaryKey = "id_kategori_barang";
    protected $fillable = [
        'kode_kategori_barang',
        'nama_kategori_barang',
        'created_by',
        'updated_by'
    ];

    public function barang()
    {
        return $this->hasMany(Barang::class, 'id_kategori_barang');
    }

    public static function generateKodeKategoriBarang()
    {
        $lastKategoriBarang = self::orderBy('id_kategori_barang', 'desc')->first();

        $nextKategoriBarangNumber = 1;
        if ($lastKategoriBarang) {
            $lastKategoriBarangNumber = (int) substr($lastKategoriBarang->kode_kategori_barang, 9);
            $nextKategoriBarangNumber = $lastKategoriBarangNumber + 1;
        }

        return 'KATEGORI-' . str_pad($nextKategoriBarangNumber, 5, '0', STR_PAD_LEFT);
    }
}
