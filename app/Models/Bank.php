<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_id',
        'user_id',
        'customer_id',
        'nama_bank',
        'atas_nama',
        'alias',
        'no_rek'
    ];

    public function customer()

    {
        return $this->belongsTo(Customer::class);
    }
}
