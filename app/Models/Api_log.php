<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Api_log extends Model
{
    protected $fillable = [
        'ip_address',
        'api_key_id',
        'api',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime', // Cast 'created_at' attribute to datetime
    ];

    public function api_key()
    {
        return $this->belongsTo(Api_key::class, 'api_key_id');
    }

}