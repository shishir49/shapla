<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'menu_name',
        'image',
        'icon',
        'parent',
        'menu_position',
        'status',
        'created_by',
    ];

    public function roleMenu()
    {
        return $this->belongsTo(RoleMenu::class);
    }

    public function menuPosition()
    {
        return $this->belongsTo('App\Models\menuPosition','menu_position');
    }

    public function childMenu()
    {
        return $this->belongsTo('App\Models\ChildMenu','parent');
    }
}
