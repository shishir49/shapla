<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Showroom extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'branch',
        'total_capacity',
        'used_space',
        'status',
    ];

    public function manager()
    {
        return $this->hasOne(Manager::class);
    }

    public function showroomProduct()
    {
        return $this->hasMany(ShowroomProduct::class);
    }

    public function supplies()
    {
        return $this->hasMany(Supply::class);
    }
}
