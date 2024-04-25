<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Api_key extends Model
{
    protected $fillable = [
        'name',
        'user_id',
        'api_key',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime', // Cast 'created_at' attribute to datetime
    ];

    public function keyuser()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}