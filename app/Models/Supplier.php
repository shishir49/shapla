<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'mobile',
        'permanent_address',
        'present_address',
        'photo',
    ];

    public function supplies()
    {
        return $this->hasMany(Supply::class);
    }
}
