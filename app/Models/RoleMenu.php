<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleMenu extends Model
{
    use HasFactory;

    protected $fillable = [
        'write',
        'read',
        'edit',
        'delete',
        'status',
        'created_by',
    ];

    public function menu()
    {
        return $this->hasOne(Menu::class);
    }

    public function roles()
    {
        return $this->hasMany(Role::class);
    }
}
