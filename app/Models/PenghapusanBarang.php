<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenghapusanBarang extends Model
{
    use HasFactory;
    protected $table = "penghapusan_barangs";
    protected $primaryKey = "id_penghapusan_barang";
    protected $fillable = [
        'kode_penghapusan_barang',
        'id_item_barang',
        'tanggal',
        'status',
        'alasan',
        'tindakan',
        'harga',
        'keterangan',
        'created_by',
        'updated_by'
    ];

    public static function generateKodePenghapusanBarang()
    {
        $lastPenghapusanBarang = self::orderBy('id_penghapusan_barang', 'desc')->first();

        $nextPenghapusanBarangNumber = 1;
        if ($lastPenghapusanBarang) {
            $lastPenghapusanBarangNumber = (int) substr($lastPenghapusanBarang->kode_penghapusan_barang, 15);
            $nextPenghapusanBarangNumber = $lastPenghapusanBarangNumber + 1;
        }

        return 'PENG-BARANG-' . str_pad($nextPenghapusanBarangNumber, 5, '0', STR_PAD_LEFT);
    }

    public function penghapusanBarang()
    {
        return $this->hasOne(PenghapusanBarang::class, 'id_item_barang');
    }
}
