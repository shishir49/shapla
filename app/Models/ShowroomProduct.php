<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShowroomProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'showroom_id',
        'warehouse_id',
        'product_id',
        'quantity',
        'selling_price',
    ];

    public function showroom()
    {
        return $this->belongsTo('App\Models\Showroom','showroom_id');
    }

    public function warhouse()
    {
        return $this->belongsTo('App\Models\Warehouse','warehouse_id');
    }

    public function products()
    {
        return $this->belongsTo('App\Models\Product','product_id');
    }
}
