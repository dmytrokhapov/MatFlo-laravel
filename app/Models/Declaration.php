<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Declaration extends Model
{
    protected $fillable = [
        'name',
        'document_id',
        'producer',
        'location',
        'verifier',
        'file_path',
        'status',
        'chain_address',
        'uploader_id',
        'published_at',
        'created_at',
        'note',
        'gwp'
    ];

    protected $casts = [
        'published_at' => 'datetime', // Cast 'published_at' attribute to datetime
        'created_at' => 'datetime', // Cast 'created_at' attribute to datetime
    ];

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploader_id');
    }

}