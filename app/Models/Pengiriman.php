<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengiriman extends Model
{
    use HasFactory;
    protected $table = 'pengirimans';

    protected $fillable = [
        'customer_id',
        'team_id',
        'sales_order_id',
        'jenis_kirim',
        'nama_ekspedisi',
        'via',
        'tujuan',
        'alamat',
        'plat_mobil',
        'sopir',
        'no_hp',
        'nama_toko',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function salesOrder()
    {
        return $this->belongsTo(SalesOrder::class);
    }
}
