<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tanah extends Model
{
    use HasFactory;
    protected $table = "tanahs";
    protected $primaryKey = "id_tanah";
    protected $fillable = [
        'kode_tanah',
        'nama_tanah',
        'lokasi',
        'sumber',
        'luas',
        'tanggal_pengadaan',
        'harga_perolehan',
        'status',
        'keterangan',
        'created_by',
        'updated_by'

    ];

    public static function generateKodeTanah()
    {
        $lastTanah = self::orderBy('id_tanah', 'desc')->first();

        $nextTanahNumber = 1;
        if ($lastTanah) {
            $lastTanahNumber = (int) substr($lastTanah->kode_tanah, 6);
            $nextTanahNumber = $lastTanahNumber + 1;
        }

        return 'TANAH-' . str_pad($nextTanahNumber, 5, '0', STR_PAD_LEFT);
    }

    public function getNilaiAsetTahunIniAttribute()
    {
        return $this->harga_pengadaan;
    }

    public function penghapusanTanah()
    {
        return $this->hasOne(PenghapusanTanah::class, 'id_tanah');
    }
}
