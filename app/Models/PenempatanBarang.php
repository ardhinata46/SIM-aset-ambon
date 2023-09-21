<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenempatanBarang extends Model
{
    use HasFactory;
    protected $table = "penempatan_barangs";
    protected $primaryKey = "id_penempatan_barang";
    protected $fillable = [
        'kode_penempatan_barang',
        'id_ruangan',
        'tanggal',
        'keterangan',
        'created_by',
        'updated_by'
    ];


    public static function generateKodePenempatanBarang()
    {
        $lastPenempatanBarang = self::orderBy('id_penempatan_barang', 'desc')->first();

        $nextPenempatanBarangNumber = 1;
        if ($lastPenempatanBarang) {
            $lastPenempatanBarangNumber = (int) substr($lastPenempatanBarang->kode_penempatan_barang, 14);
            $nextPenempatanBarangNumber = $lastPenempatanBarangNumber + 1;
        }

        return 'PTN-BARANG-' . str_pad($nextPenempatanBarangNumber, 5, '0', STR_PAD_LEFT);
    }
}
