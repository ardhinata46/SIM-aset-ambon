<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class SuperAdmin extends Authenticatable
{
    use Notifiable;

    protected $table = "penggunas";
    protected $primaryKey = "id_pengguna";
    protected $fillable = [
        'nama_pengguna', 'role', 'email', 'password', 'status',
    ];

    protected $hidden = [
        'password', 'token',
    ];
}
