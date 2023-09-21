<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengembalianBarang extends Model
{
    use HasFactory;
    protected $table = "pengembalian_barangs";
    protected $primaryKey = "id_pengembalian_barang";
    protected $fillable = [
        'kode_pengembalian_barang',
        'id_peminjaman_barang',
        'tanggal',
        'status',
        'keterangan',
        'created_by',
        'updated_by'
    ];

    public static function generateKodePengembalianBarang()
    {
        $lastPengembalianBarang = self::orderBy('id_pengembalian_barang', 'desc')->first();

        $nextPengembalianBarangNumber = 1;
        if ($lastPengembalianBarang) {
            $lastPengembalianBarangNumber = (int) substr($lastPengembalianBarang->kode_pengembalian_barang, 17);
            $nextPengembalianBarangNumber = $lastPengembalianBarangNumber + 1;
        }

        return 'PENGEMBALIAN-' . str_pad($nextPengembalianBarangNumber, 5, '0', STR_PAD_LEFT);
    }
}
