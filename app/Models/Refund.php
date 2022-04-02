<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
    use HasFactory;

    protected $fillable = [
        'refund_percentage',
        'refund_amount',
        'quantity',
        'refunded_for',
        'refunded_by',
        'status'
    ];

    public function sales()
    {
        return $this->belongsTo('App\Models\Sale','sale_id');
    }
}
