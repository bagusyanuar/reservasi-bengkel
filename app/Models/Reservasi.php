<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservasi extends Model
{
    use HasFactory;

    protected $table = 'reservasi';

    protected $fillable = [
        'user_id',
        'tanggal',
        'no_reservasi',
        'paket_id',
        'jenis_kendaraan',
        'plat',
        'status',
        'total',
        'keterangan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function paket()
    {
        return $this->belongsTo(Paket::class, 'paket_id');
    }

    public function pembayaran_lunas()
    {
        return $this->hasOne(Pembayaran::class, 'reservasi_id')->where('jenis', '=', 'dp');
    }

    public function tambahan()
    {
        return $this->hasMany(ReservasiTambahan::class, 'reservasi_id');
    }

    public function dp()
    {
        return $this->hasMany(Pembayaran::class, 'reservasi_id')
            ->where('jenis', '=', 'dp')
            ->where('status', '=', 'terima');
    }

    public function pelunasan()
    {
        return $this->hasMany(Pembayaran::class, 'reservasi_id')
            ->where('jenis', '=', 'pelunasan')
            ->where('status', '=', 'terima');
    }
}
