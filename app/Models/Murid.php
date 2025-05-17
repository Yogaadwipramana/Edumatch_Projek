<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Murid extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bidang_pelatihan',
        'lokasi',
        'file_identitas',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
