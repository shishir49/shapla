<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChildMenu extends Model
{
    use HasFactory;

    protected $fillable = [
        'menu_name',
        'image',
        'icon',
        'parent',
        'status',
        'created_by',
    ];
}
