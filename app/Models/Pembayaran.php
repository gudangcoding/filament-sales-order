<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;
    protected $fillable = [
        'sales_order_id',
        'tanggal',
        'jumlah_hutang',
        'jumlah_bayar',
        'sisa',
        'bukti_bayar',
    ];
}
