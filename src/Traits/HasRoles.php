<?php

namespace LaravelGreatApi\Access\Traits;

use LaravelGreatApi\Access\Models\Role;

trait HasRoles
{
    /**
     * Undocumented function
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles', 'user_id', 'role_id');
    }

    /**
     * Undocumented function
     *
     * @param string|array $roles
     * @return boolean
     */
    public function hasRole(string|array $roles): bool
    {
        return $this->whereHas('roles', fn($q) => $q->whereIn('slug', $this->getArgs($roles)))->exists();
    }

    /**
     * Undocumented function
     *
     * @return boolean
     */
    public function hasRootRole(): bool
    {
        return $this->roles()->where('root', true)->exists();
    }

    /**
     * Undocumented function
     *
     * @param string|Role $role
     * @return array
     */
    public function assignRole(string|Role $role): array
    {
        $role = is_string($role) ? Role::where('slug', $role)->first() : $role;

        return $this->roles()->syncWithoutDetaching($role->id);
    }
}
