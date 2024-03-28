<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'name',
        'document_id',
        'producer_id',
        'file_path',
        'status',
        'chain_address',
        'verifier_id',
        'signed_file_path',
        'verified_at',
        'created_at',
        'note',
    ];

    protected $casts = [
        'verified_at' => 'datetime', // Cast 'verified_at' attribute to datetime
        'created_at' => 'datetime', // Cast 'created_at' attribute to datetime
    ];

    public function producer()
    {
        return $this->belongsTo(User::class, 'producer_id');
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verifier_id');
    }
}