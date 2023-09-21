<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemMutasiBarang extends Model
{
    use HasFactory;
    protected $table = "item_mutasi_barangs";
    protected $primaryKey = "id_item_mutasi_barang";
    protected $fillable = [
        'id_mutasi_barang',
        'id_item_barang',
        'ruangan_awal'
    ];
}
