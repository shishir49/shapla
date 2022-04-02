<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuPosition extends Model
{
    use HasFactory;

    protected $fillable = [
        'position_name',
        'status',
        'created_by',
    ];
}
