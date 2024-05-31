<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SalesOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'so_no',
        'team_id',
        'user_id',
        'customer_id',
        'subtotal',
        'qty',
        'diskon',
        'ongkir',
        'grand_total',
        'tanggal',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function Pembayaran()
    {
        return $this->belongsTo(Pembayaran::class, 'sales_order_id');
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function order_details()
    {
        return $this->hasMany(SalesDetail::class, 'sales_order_id');
    }
    public function SalesDetail()
    {
        return $this->hasMany(SalesDetail::class, 'sales_order_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pengiriman()
    {
        return $this->hasMany(Pengiriman::class, 'sales_order_id');
    }
}
