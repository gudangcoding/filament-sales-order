<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerClass extends Model
{
    use HasFactory;
    protected $fillable = [
        "name",
        "team_id",
        "user_id"
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
