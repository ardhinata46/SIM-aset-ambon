<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MutasiBarang extends Model
{
    use HasFactory;
    protected $table = "mutasi_barangs";
    protected $primaryKey = "id_mutasi_barang";
    protected $fillable = [
        'kode_mutasi_barang',
        'id_item_barang',
        'id_ruangan_awal',
        'id_ruangan_tujuan',
        'tanggal',
        'keterangan',
        'created_by',
        'updated_by'
    ];


    public static function generateKodeMutasiBarang()
    {
        $lastMutasiBarang = self::orderBy('id_Mutasi_barang', 'desc')->first();

        $nextMutasiBarangNumber = 1;
        if ($lastMutasiBarang) {
            $lastMutasiBarangNumber = (int) substr($lastMutasiBarang->kode_mutasi_barang, 17);
            $nextMutasiBarangNumber = $lastMutasiBarangNumber + 1;
        }

        return 'MUTASI-BARANG-' . str_pad($nextMutasiBarangNumber, 5, '0', STR_PAD_LEFT);
    }
}
