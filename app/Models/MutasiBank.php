<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MutasiBank extends Model
{
    use HasFactory;
    protected $fillable = [
        'team_id',
        'user_id',
        'tanggal',
        'keterangan',
        'nama',
        'cabang',
        'jumlah',
        'type',
        'saldo',
    ];


    public function team(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Team::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
