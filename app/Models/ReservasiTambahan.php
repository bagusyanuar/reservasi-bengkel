<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservasiTambahan extends Model
{
    use HasFactory;

    protected $table = 'reservasi_tambahan';

    protected $fillable = [
        'user_id',
        'reservasi_id',
        'layanan_id',
        'qty',
        'harga',
        'total',
    ];

    public function reservasi()
    {
        return $this->belongsTo(Reservasi::class, 'reservasi_id');
    }

    public function layanan()
    {
        return $this->belongsTo(Layanan::class, 'layanan_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
