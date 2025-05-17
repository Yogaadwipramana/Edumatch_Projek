<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Tambahkan relasi ke Guru
    // app/Models/User.php
    public function murid()
    {
        return $this->hasOne(Murid::class);
    }

    public function guru()
    {
        return $this->hasOne(Guru::class);
    }

    public function requestsSent()
    {
        return $this->hasMany(Request::class, 'murid_id');
    }

    public function requestsReceived()
    {
        return $this->hasMany(Request::class, 'guru_id');
    }
}
