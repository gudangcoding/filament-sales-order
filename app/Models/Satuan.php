<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Satuan extends Model
{
    use HasFactory;
    protected $fillable = [
        "team_id",
        "user_id",
        "product_id",
        "parent_id",
        "type",
        'name',
        'qty',
        'harga'
    ];
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsToMany(Product::class);
    }
}
