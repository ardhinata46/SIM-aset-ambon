<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenghapusanTanah extends Model
{
    use HasFactory;
    protected $table = "penghapusan_tanahs";
    protected $primaryKey = "id_penghapusan_tanah";
    protected $fillable = [
        'kode_penghapusan_tanah',
        'id_tanah',
        'tanggal',
        'status',
        'tindakan',
        'harga',
        'keterangan',
        'created_by',
        'updated_by'
    ];

    public static function generateKodePenghapusanTanah()
    {
        $lastPenghapusanTanah = self::orderBy('id_penghapusan_tanah', 'desc')->first();

        $nextPenghapusanTanahNumber = 1;
        if ($lastPenghapusanTanah) {
            $lastPenghapusanTanahNumber = (int) substr($lastPenghapusanTanah->kode_penghapusan_tanah, 14);
            $nextPenghapusanTanahNumber = $lastPenghapusanTanahNumber + 1;
        }

        return 'PENG-TANAH-' . str_pad($nextPenghapusanTanahNumber, 5, '0', STR_PAD_LEFT);
    }

    public function tanah()
    {
        return $this->belongsTo(Tanah::class, 'id_tanah');
    }
}
