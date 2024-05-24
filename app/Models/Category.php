<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', "user_id", "team_id"];



    public function products()
    {
        return $this->hasMany(\App\Models\Product::class);
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Team::class);
    }
}
