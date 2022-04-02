<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supply extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_id',
        'product_id',
        'warehouse_id',
        'showroom_id',
        'quantity',
        'rate',
        'status',
    ];

    public function suppliers()
    {
        return $this->belongsTo(User::class, 'supplier_id');
    }

    // public function products()
    // {
    //     return $this->hasMany(Product::class);
    // }

    // public function warehouses()
    // {
    //     return $this->hasMany(Warehouse::class);
    // }

    // public function showrooms()
    // {
    //     return $this->hasMany(Showroom::class);
    // }
}
