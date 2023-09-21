<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemPengadaanBarang extends Model
{
    use HasFactory;
    protected $table = "item_pengadaan_barangs";
    protected $primaryKey = "id_item_pengadaan_barang";
    protected $fillable = [
        'id_pengadaan_barang',
        'id_barang',
        'nama_item_barang',
        'merk',
        'harga_perolehan',
        'umur_manfaat',
        'nilai_residu',
        'jumlah',
    ];
}
