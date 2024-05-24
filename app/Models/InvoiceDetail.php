<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'total_qty',
        'total_amount',
    ];

    /**
     * Mendefinisikan relasi ke model Team.
     */
    public function team()
    {
        return $this->belongsTo(\App\Models\Team::class);
    }
}
