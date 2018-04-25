<?php

namespace App\Models;

class Permission extends \Spatie\Permission\Models\Permission
{
    public $timestamps = true;

    /**
     * A permission can be applied to roles.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(
            config('laravel-permission.models.role'),
            config('laravel-permission.table_names.role_has_permissions')
        )->withTimestamps();
    }
}
