<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TableAccess extends Model
{
    use HasFactory;

    protected $fillable = [
        'table_name',
        'read',
        'write',
        'edit',
        'delete',
    ];

    public function roles()
    {
        return $this->hasMany(Role::class);
    }
}
