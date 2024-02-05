<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseDetail extends Model
{
    use HasFactory;

    public function getAmountAttribute($value)
    {
        return strpos($value, '.') !== false ? rtrim(rtrim($value, '0'), '.') : $value;
    }
}
