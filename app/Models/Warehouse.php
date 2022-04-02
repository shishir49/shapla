<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'manager',
        'total_capacity',
        'used_space',
        'status',
    ];

    public function warehouseProducts()
    {
        return $this->hasMany(WarehouseProduct::class);
    }

    public function supplies()
    {
        return $this->hasMany(Supply::class);
    }
}
