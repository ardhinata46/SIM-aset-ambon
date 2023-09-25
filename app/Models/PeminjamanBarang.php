<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeminjamanBarang extends Model
{
    use HasFactory;
    protected $table = "peminjaman_barangs";
    protected $primaryKey = "id_peminjaman_barang";
    protected $fillable = [
        'kode_peminjaman_barang',
        'tanggal',
        'status',
        'nama_peminjam',
        'kontak',
        'alamat',
        'created_by',
        'updated_by'
    ];

    public static function generateKodePeminjamanBarang()
    {
        $lastPeminjamanBarang = self::orderBy('id_peminjaman_barang', 'desc')->first();

        $nextPeminjamanBarangNumber = 1;
        if ($lastPeminjamanBarang) {
            $lastPeminjamanBarangNumber = (int) substr($lastPeminjamanBarang->kode_peminjaman_barang, 15);
            $nextPeminjamanBarangNumber = $lastPeminjamanBarangNumber + 1;
        }

        return 'PEMINJAMAN-' . str_pad($nextPeminjamanBarangNumber, 5, '0', STR_PAD_LEFT);
    }

    public function pengembalianBarang()
    {
        return $this->hasOne(PengembalianBarang::class, 'id_peminjaman_barang', 'id_peminjaman_barang');
    }
}
