<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    protected $table = "barangs";
    protected $primaryKey = "id_barang";
    protected $fillable = [
        'id_kategori_barang',
        'kode_barang',
        'nama_barang',
        'created_by',
        'updated_by'
    ];

    public function kategori_barang()
    {
        return $this->belongsTo(KategoriBarang::class, 'id_kategori_barang');
    }

    public function item_barang()
    {
        return $this->hasMany(ItemBarang::class, 'id_barang');
    }

    public static function generateKodeBarang()
    {
        $lastBarang = self::orderBy('kode_barang', 'desc')->first();

        $nextBarangNumber = 1;
        if ($lastBarang) {
            $lastBarangNumber = (int) substr($lastBarang->kode_barang, 7);
            $nextBarangNumber = $lastBarangNumber + 1;
        }

        return 'BARANG-' . str_pad($nextBarangNumber, 5, '0', STR_PAD_LEFT);
    }
}
