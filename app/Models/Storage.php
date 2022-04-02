<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Storage extends Model
{
    use HasFactory;

    protected $fillable = [
        'storage_type',
        'storage_name',
        'manager_id',
        'employees',
        'address',
        'total_capacity',
        'used_space',
        'status'
    ];
}
