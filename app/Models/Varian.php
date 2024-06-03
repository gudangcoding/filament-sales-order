<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Varian extends Model
{
    use HasFactory;
    protected $fillable = ['product_id', 'satuan_id', 'satuan', 'harga', 'stok'];

    public function produk()
    {
        return $this->belongsTo(Product::class);
    }

    public function satuan()
    {
        return $this->belongsTo(Satuan::class);
    }
}
