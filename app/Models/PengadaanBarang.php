<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengadaanBarang extends Model
{
    use HasFactory;
    protected $table = "pengadaan_barangs";
    protected $primaryKey = "id_pengadaan_barang";
    protected $fillable = [
        'kode_pengadaan_barang',
        'tanggal_pengadaan',
        'sumber',
        'keterangan',
        'nota',
        'created_by',
        'updated_by'
    ];

    public function item_pengadaan_barang()
    {
        return $this->hasMany(ItemPengadaanBarang::class, 'item_pengadaan_barang');
    }


    public static function generateKodePengadaanBarang()
    {
        $lastPengadaanBarang = self::orderBy('id_pengadaan_barang', 'desc')->first();

        $nextPengadaanBarangNumber = 1;
        if ($lastPengadaanBarang) {
            $lastPengadaanBarangNumber = (int) substr($lastPengadaanBarang->kode_pengadaan_barang, 16);
            $nextPengadaanBarangNumber = $lastPengadaanBarangNumber + 1;
        }

        return 'TRANS-BARANG-' . str_pad($nextPengadaanBarangNumber, 5, '0', STR_PAD_LEFT);
    }
}
