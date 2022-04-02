<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarehouseProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'warehouse_id',
        'supply_id',
        'product_id',
        'quantity',
        'purchase_price',
    ];

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function Products()
    {
        return $this->hasMany(Product::class);
    }
}
