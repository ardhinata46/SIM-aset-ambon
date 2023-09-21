<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenghapusanBangunan extends Model
{
    use HasFactory;
    protected $table = "penghapusan_bangunans";
    protected $primaryKey = "id_penghapusan_bangunan";
    protected $fillable = [
        'kode_penghapusan_bangunan',
        'id_bangunan',
        'tanggal',
        'status',
        'tindakan',
        'harga',
        'keterangan',
        'created_by',
        'updated_by'
    ];

    public static function generateKodePenghapusanBangunan()
    {
        $lastPenghapusanBangunan = self::orderBy('id_penghapusan_bangunan', 'desc')->first();

        $nextPenghapusanBangunanNumber = 1;
        if ($lastPenghapusanBangunan) {
            $lastPenghapusanBangunanNumber = (int) substr($lastPenghapusanBangunan->kode_penghapusan_bangunan, 17);
            $nextPenghapusanBangunanNumber = $lastPenghapusanBangunanNumber + 1;
        }

        return 'PENG-BANGUNAN-' . str_pad($nextPenghapusanBangunanNumber, 5, '0', STR_PAD_LEFT);
    }

    public function bangunan()
    {
        return $this->belongsTo(Bangunan::class, 'id_bangunan');
    }
}
