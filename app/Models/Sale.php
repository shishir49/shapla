<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'quantity',
        'rate',
        'gross_price',
        'sold_by',
        'sold_to',
        'status'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function refunds()
    {
        return $this->hasMany(Refund::class);
    }
}
