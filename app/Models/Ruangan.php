<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    use HasFactory;
    protected $table = "ruangans";
    protected $primaryKey = "id_ruangan";
    protected $fillable = [
        'id_bangunan',
        'kode_ruangan',
        'nama_ruangan'
    ];

    public static function generateKodeRuangan()
    {
        $lastRuangan = self::orderBy('id_ruangan', 'desc')->first();

        $nextRuanganNumber = 1;
        if ($lastRuangan) {
            $lastRuanganNumber = (int) substr($lastRuangan->kode_ruangan, 8);
            $nextRuanganNumber = $lastRuanganNumber + 1;
        }

        return 'RUANGAN-' . str_pad($nextRuanganNumber, 5, '0', STR_PAD_LEFT);
    }
}
