<?php

namespace LaravelGreatApi\Access\Traits;

use LaravelGreatApi\Access\Models\Permission;

trait HasPermissions
{
    public function permissions()
    {
        return $this->morphToMany(
            Permission::class,
            'permissionable',
            'permissionables',
            'permissionable_id',
            'permission_id'
        );
    }
}
