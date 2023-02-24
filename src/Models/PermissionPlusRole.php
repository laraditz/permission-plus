<?php

namespace Laraditz\PermissionPlus\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissionPlusRole extends Model
{
    use HasFactory;

    protected $fillable = ['permission_plus_id', 'role_id'];

    public function permissionPlus()
    {
        return $this->belongsToMany(PermissionPlus::class);
    }

    public function role()
    {
        return $this->belongsToMany(Role::class);
    }
}
