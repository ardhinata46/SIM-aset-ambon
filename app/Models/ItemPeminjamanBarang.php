<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemPeminjamanBarang extends Model
{
    use HasFactory;
    protected $table = "item_peminjaman_barangs";
    protected $primaryKey = "id_item_peminjaman_barang";
    protected $fillable = [
        'id_peminjaman_barang',
        'id_item_barang',
    ];

    public function peminjamanBarang()
    {
        return $this->belongsTo(PeminjamanBarang::class, 'id_peminjaman_barang');
    }
}
