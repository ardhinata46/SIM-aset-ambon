<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerawatanBangunan extends Model
{
    use HasFactory;
    protected $table = "perawatan_bangunans";
    protected $primaryKey = "id_perawatan_bangunan";
    protected $fillable = [
        'kode_perawatan_bangunan',
        'id_bangunan',
        'tanggal_perawatan',
        'kondisi_sebelum',
        'kondisi_sesudah',
        'deskripsi',
        'biaya',
        'nota',
        'keterangan',
        'created_by',
        'updated_by'
    ];

    public static function generateKodePerawatanBangunan()
    {
        $lastPerawatanBangunan = self::orderBy('id_perawatan_bangunan', 'desc')->first();

        $nextPerawatanBangunanNumber = 1;
        if ($lastPerawatanBangunan) {
            $lastPerawatanBangunanNumber = (int) substr($lastPerawatanBangunan->kode_perawatan_bangunan, 16);
            $nextPerawatanBangunanNumber = $lastPerawatanBangunanNumber + 1;
        }

        return 'PER-BANGUNAN-' . str_pad($nextPerawatanBangunanNumber, 5, '0', STR_PAD_LEFT);
    }
}
