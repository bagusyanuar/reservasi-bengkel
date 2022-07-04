<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id',
        'nama',
        'harga',
        'deskripsi',
        'gambar'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
