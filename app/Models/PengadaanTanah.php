<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengadaanTanah extends Model
{
    use HasFactory;
    protected $table = "pengadaan_tanahs";
    protected $primaryKey = "id_pengadaan_tanah";
    protected $fillable = [
        'kode_pengadaan_tanah',
        'kode_tanah',
        'nama_tanah',
        'lokasi',
        'sumber',
        'luas',
        'tanggal_pengadaan',
        'harga_perolehan',
        'nota',
        'keterangan',
        'created_by',
        'updated_by'
    ];

    public static function generateKodePengadaanTanah()
    {
        $lastPengadaanTanah = self::orderBy('id_pengadaan_tanah', 'desc')->first();

        $nextPengadaanTanahNumber = 1;
        if ($lastPengadaanTanah) {
            $lastPengadaanTanahNumber = (int) substr($lastPengadaanTanah->kode_pengadaan_tanah, 13);
            $nextPengadaanTanahNumber = $lastPengadaanTanahNumber + 1;
        }

        return 'TRANS-TANAH-' . str_pad($nextPengadaanTanahNumber, 5, '0', STR_PAD_LEFT);
    }
}
