<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lend extends Model
{
    use HasFactory;

    protected $fillable = [
        'borrower_name',
        'lend_amount',
        'phone',
        'email',
        'permanent_address',
        'current_address',
        'nid',
        'occupation',
        'status'
    ];
}
