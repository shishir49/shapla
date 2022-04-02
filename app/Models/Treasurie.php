<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Treasurie extends Model
{
    use HasFactory;

    protected $fillable = [
        'total_credit',
        'total_spent',
        'on_hand',
        'total_lend',
        'sell',
        'refund'
    ];
}
