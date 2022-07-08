<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paket extends Model
{
    use HasFactory;

    protected $table = 'paket';

    protected $fillable = [
        'nama',
        'deskripsi',
        'harga'
    ];

    public function layanan()
    {
        return $this->belongsToMany(Layanan::class, 'paket_layanan');
    }

}
