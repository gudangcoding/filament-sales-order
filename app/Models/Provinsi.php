<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Provinsi extends Model
{
    use HasFactory;

    protected $table = "provinsi";

    protected $fillable = [
        'id',
        'name',
        'team_id',
        'user_id',
    ];

    public function kabupatens()
    {
        return $this->hasMany(Kabupaten::class, 'provinsi_id');
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Team::class);
    }
}
