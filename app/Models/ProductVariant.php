<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id',
        'gambar',
        'harga',
        'satuan',
        'isi',
        'stok',
    ];

    public function product()
    {
        return $this->belongsTo(\App\Models\Product::class, 'product_id');
    }
}
