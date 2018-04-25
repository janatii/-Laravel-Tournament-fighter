<?php

namespace App\Models;

class Role extends \Spatie\Permission\Models\Role
{
    public $timestamps = true;

    /**
     * A role may be given various permissions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->belongsToMany(
            config('laravel-permission.models.permission'),
            config('laravel-permission.table_names.role_has_permissions')
        )->withTimestamps();
    }
    
    public function __toString()
    {
        return $this->name;
    }
}
