<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alamat extends Model
{
    use HasFactory;
    protected $fillable = [
        'team_id',
        'user_id',
        'negara',
        'provinsi',
        'kabupaten_kota',
        'kecamatan',
        'kelurahan_desa',
        'rt_rw',
        'alamat',
        'no_unit',
        'tambahan',
        'kode_pos',
        'label_alamat',
    ];
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
