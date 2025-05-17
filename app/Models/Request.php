<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    protected $fillable = [
        'murid_id',
        'guru_id',
        'pesan',
        'status',
        'tanggal_request',
        'tanggal_deal'
    ];

    protected $dates = [
        'tanggal_request',
        'tanggal_deal',
        'created_at',
        'updated_at'
    ];

    public function murid()
    {
        return $this->belongsTo(Murid::class);
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function negotiations()
    {
        return $this->hasMany(Negotiation::class);
    }
}