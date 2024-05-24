<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_id',
        'user_id',
        'order_number',
        'status',
        'type_bayar',
        'tanggal',
        'tempo',
        'total_amount',
        'dp',
        'sisa',
        'kembali'
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Team::class);
    }

    public function invoice_detail()
    {
        return $this->hasMany(\App\Models\InvoiceDetail::class);
    }
}
