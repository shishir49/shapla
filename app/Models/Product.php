<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'product_name',
        'varient',
        'status',
    ];

    public function warehouseProducts()
    {
        return $this->belongsTo(WarehouseProduct::class);
    }

    public function showroomProduct()
    {
        return $this->belongsTo(ShowroomProduct::class);
    }

    public function category()
    {
        return $this->hasOne(Category::class);
    }

    public function product_variant()
    {
        return $this->hasMany('App\Http\Models\ProductVarient','product_varient_id');
    }

    public function productImages()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function productPrice()
    {
        return $this->hasOne(ProductPrice::class);
    }

    public function discount()
    {
        return $this->hasOne(Discount::class);
    }

    public function supplies()
    {
        return $this->hasMany(Supply::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}
