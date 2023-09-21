<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profil extends Model
{
    use HasFactory;
    protected $table = "profils";
    protected $primaryKey = "id_profil";
    protected $fillable = [
        'nama_aplikasi',
        'nama_organisasi',
        'alamat',
        'logo',
        'email',
        'updated_by'
    ];
}
