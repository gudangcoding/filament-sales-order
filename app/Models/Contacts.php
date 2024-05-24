<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contacts extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_id',
        'user_id',
        'customer_id',
        'no_hp',
        'nama',
        'sebutan',
        'hubungan',
        'msg_app'
    ];



    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
