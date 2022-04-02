<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use HasFactory;

    protected $fillable = [
       'from',
       'to',
       'product_id',
       'supply_id',
       'quantity',
       'status'
    ];

    public function storages_from()
    {
        return $this->belongsTo('App\Models\Storage','from');
    }

    public function storages_to()
    {
        return $this->belongsTo('App\Models\Storage','to');
    }

    public function products()
    {
        return $this->belongsTo('App\Models\Product','product_id');
    }
}
