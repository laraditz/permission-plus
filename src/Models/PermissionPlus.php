<?php

namespace Laraditz\PermissionPlus\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PermissionPlus extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'permission_plus';

    protected $fillable = ['name', 'methods', 'uri', 'route_name', 'action_name', 'allow_all', 'allow_guest', 'sort_order', 'is_active'];

    protected $casts = [
        'methods' => 'json',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($model) {
            $model->sort_order = $model->max('sort_order') + 1;
        });
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    protected function getRoleNamesAttribute()
    {
        return $this->allow_all ? 'All Roles' : ($this->roles->count() > 0 ? Str::title($this->roles->implode('name', ', ')) : null);
    }

    protected function getMethodTextAttribute()
    {
        return $this->methods && count($this->methods) > 0 ? implode(', ', $this->methods) : null;
    }

    protected function getPermissionTextAttribute()
    {
        if ($this->allow_all) {
            return 'Allow All';
        } else {
            $allow_text = [];

            if ($this->allow_guest) {
                $allow_text[] = 'Guest';
            }

            if ($this->role_names) {
                $allow_text[] = $this->role_names;
            }

            if (count($allow_text) > 0) {
                return 'Allow ' . implode(', ', $allow_text);
            }
        }

        return 'Denied';
    }
}
