<?php

namespace LaravelGreatApi\Access\Traits;

use Illuminate\Support\Collection;
use LaravelGreatApi\Access\Models\Permission;
use LaravelGreatApi\Access\Models\Role;
use LaravelGreatApi\Access\Models\Team;

trait HasAccess
{
    use HasPermissions;

    /**
     * Undocumented function
     *
     * @param string|array $args
     * @return array
     */
    private function getArgs(string|array $args): array
    {
        return array_merge(is_array($args) ? $args : func_get_args());
    }

    /**
     * Undocumented function
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function teams()
    {
        return $this->belongsToMany(Team::class, 'user_teams', 'user_id', 'team_id');
    }

    /**
     * Undocumented function
     *
     * @param string|array $teams
     * @return boolean
     */
    public function hasTeam(string|array $teams): bool
    {
        return $this->whereHas('teams', fn($q) => $q->whereIn('slug', $this->getArgs($teams)))->exists();
    }

    /**
     * Undocumented function
     *
     * @param string|array $permissions
     * @return boolean
     */
    public function hasTeamsPermissions(string|array $permissions): bool
    {
        return $this->teams()->whereHas('permissions', fn($q) => $q->whereIn('slug', $this->getArgs($permissions)))->exists();
    }

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
     * @return array
     */
    public function getPermissions(): array
    {
        return $this->permissionsCollection()->unique('slug')->values()->toArray();
    }
}
