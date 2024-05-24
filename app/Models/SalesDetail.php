<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesDetail extends Model
{
    use HasFactory;
    protected $table = "sales_detail";
    protected $fillable = [
        'sales_order_id',
        'product_id',
        'satuan',
        'harga',
        'qty',
        'subtotal',
        'koli',
        'jumlah_koli'
    ];

    public function salesOrder()
    {
        return $this->BelongsToMany(SalesOrder::class, 'sales_order_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
