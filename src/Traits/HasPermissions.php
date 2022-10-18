<?php

namespace LaravelGreatApi\Access\Traits;

use Illuminate\Support\Collection;
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

    /**
     * Undocumented function
     *
     * @return array
     */
    public function getPermissions(): array
    {
        return $this->permissionsCollection()->unique('slug')->values()->toArray();
    }

    /**
     * Undocumented function
     *
     * @param string|array $permissions
     * @return boolean
     */
    public function hasRolesPermissions(string|array $permissions): bool
    {
        if ($this->hasRootRole()) {
            return true;
        }

        return $this->roles()->whereHas('permissions', fn($q) => $q->whereIn('slug', $this->getArgs($permissions)))->exists();
    }

    /**
     * Undocumented function
     *
     * @param string|array $permissions
     * @return boolean
     */
    public function hasUserPermissions(string|array $permissions): bool
    {
        return $this->whereHas('permissions', fn($q) => $q->whereIn('slug', $this->getArgs($permissions)))->exists();
    }

    /**
     * Undocumented function
     *
     * @param string|array $permissions
     * @return boolean
     */
    public function hasPermissions(string|array $permissions): bool
    {
        return $this->hasTeamsPermissions($permissions)
            || $this->hasRolesPermissions($permissions)
            || $this->hasUserPermissions($permissions);
    }

    /**
     * Undocumented function
     *
     * @return array
     */
    public function getTeamsPermissions(): array
    {
        return $this->teams->map(fn($t) => $t->permissions)->collapse()->toArray();
    }

    /**
     * Undocumented function
     *
     * @return array
     */
    public function getRolesPermissions(): array
    {
        if ($this->hasRootRole()) {
            return Permission::all()->toArray();
        }

        return $this->roles->map(fn($t) => $t->permissions)->collapse()->toArray();
    }

    /**
     * Undocumented function
     *
     * @return array
     */
    public function getUserPermissions(): array
    {
        return $this->permissions->toArray();
    }

    /**
     * Undocumented function
     *
     * @return Collection
     */
    private function permissionsCollection(): Collection
    {
        return new Collection(array_merge(
            $this->getTeamsPermissions(),
            $this->getRolesPermissions(),
            $this->getUserPermissions()
        ));
    }

    /**
     * Undocumented function
     *
     * @param string|Permission $permission
     * @return array
     */
    public function assignPermission(string|Permission $permission): array
    {
        $permission = is_string($permission) ? Permission::where('slug', $permission)->first() : $permission;

        return $this->permissions()->syncWithoutDetaching($permission->id);
    }
}
