<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = [
        'roles',
        'status',
        'created_by',
    ];

    public function roleMenu()
    {
        return $this->hasMany(RoleMenu::class);
    }

    public function tableAccesses()
    {
        return $this->hasMany(TableAccess::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
