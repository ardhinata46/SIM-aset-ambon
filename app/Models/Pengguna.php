<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengguna extends Model
{
    use HasFactory;
    protected $table = "penggunas";
    protected $primaryKey = "id_pengguna";
    protected $fillable = [
        'nama_pengguna',
        'role',
        'jk',
        'email',
        'password',
        'alamat',
        'status',
        'foto'

    ];
    protected $hidden = [
        'password', 'remember_token',
    ];
}
