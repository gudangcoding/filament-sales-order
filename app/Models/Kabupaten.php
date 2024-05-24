<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kabupaten extends Model
{
    use HasFactory;

    protected $table = "kabupaten";

    protected $fillable = [
        'team_id',
        'user_id',
        'provinsi_id',
        'name',
    ];

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class, 'provinsi_id');
    }
}
