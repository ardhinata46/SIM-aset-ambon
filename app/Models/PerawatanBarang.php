<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerawatanBarang extends Model
{
    use HasFactory;
    protected $table = "perawatan_barangs";
    protected $primaryKey = "id_perawatan_barang";
    protected $fillable = [
        'kode_perawatan_barang',
        'id_item_barang',
        'tanggal_perawatan',
        'kondisi_sebelum',
        'kondisi_sesudah',
        'deskripsi',
        'biaya',
        'keterangan',
        'created_by',
        'updated_by'
    ];

    public static function generateKodePerawatanBarang()
    {
        $lastPerawatanBarang = self::orderBy('id_perawatan_barang', 'desc')->first();

        $nextPerawatanBarangNumber = 1;
        if ($lastPerawatanBarang) {
            $lastPerawatanBarangNumber = (int) substr($lastPerawatanBarang->kode_perawatan_barang, 14);
            $nextPerawatanBarangNumber = $lastPerawatanBarangNumber + 1;
        }

        return 'PER-BARANG-' . str_pad($nextPerawatanBarangNumber, 5, '0', STR_PAD_LEFT);
    }
}
