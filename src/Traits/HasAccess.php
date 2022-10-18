<?php

namespace LaravelGreatApi\Access\Traits;

use LaravelGreatApi\Access\Models\Role;
use LaravelGreatApi\Access\Models\Team;

trait HasAccess
{
    use HasPermissions, HasTeams, HasRoles;

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
}
