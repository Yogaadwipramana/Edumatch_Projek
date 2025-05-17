<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Negotiation extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_id',
        'user_id',
        'pesan',
        'harga',
        'waktu_pelaksanaan'
    ];

    protected $dates = [
        'waktu_pelaksanaan',
        'created_at',
        'updated_at'
    ];

    public function request()
    {
        return $this->belongsTo(Request::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}