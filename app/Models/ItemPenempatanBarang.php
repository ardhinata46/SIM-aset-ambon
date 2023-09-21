<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemPenempatanBarang extends Model
{
    use HasFactory;
    protected $table = "item_penempatan_barangs";
    protected $primaryKey = "id_item_penempatan_barang";
    protected $fillable = [
        'id_penempatan_barang',
        'id_item_barang'
    ];
}
