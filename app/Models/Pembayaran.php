<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    protected $table = 'pembayaran';

    protected $fillable = [
        'reservasi_id',
        'tanggal',
        'bank',
        'no_rekening',
        'atas_nama',
        'total',
        'bukti',
        'status',
        'jenis',
        'keterangan',
    ];

    public function reservasi()
    {
        return $this->belongsTo(Reservasi::class, 'reservasi_id');
    }
}
