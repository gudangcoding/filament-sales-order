<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    use HasFactory;

    protected $table = "kecamatan";
    protected $fillable = [
        'team_id',
        'user_id',
        'kabupaten_id',
        'name',
    ];
    public function kecamatan()
    {
        return $this->belongsTo(Kabupaten::class, 'kabupaten_id');
    }
}
