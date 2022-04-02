<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'price',
        'status',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
