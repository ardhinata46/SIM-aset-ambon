<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengadaanBangunan extends Model
{
    use HasFactory;
    protected $table = "pengadaan_bangunans";
    protected $primaryKey = "id_pengadaan_bangunan";
    protected $fillable = [
        'id_tanah',
        'kode_pengadaan_bangunan',
        'nama_bangunan',
        'lokasi',
        'kondisi',
        'deskripsi',
        'tanggal_pengadaan',
        'sumber',
        'harga_perolehan',
        'umur_manfaat',
        'nilai_residu',
        'nota',
        'keterangan',
        'created_by',
        'updated_by'
    ];

    public static function generateKodePengadaanBangunan()
    {
        $lastPengadaanBangunan = self::orderBy('id_pengadaan_bangunan', 'desc')->first();

        $nextPengadaanBangunanNumber = 1;
        if ($lastPengadaanBangunan) {
            $lastPengadaanBangunanNumber = (int) substr($lastPengadaanBangunan->kode_pengadaan_bangunan, 17);
            $nextPengadaanBangunanNumber = $lastPengadaanBangunanNumber + 1;
        }

        return 'TRANS-BANGUNAN-' . str_pad($nextPengadaanBangunanNumber, 5, '0', STR_PAD_LEFT);
    }
}
