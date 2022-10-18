<?php

namespace LaravelGreatApi\Access;

use LaravelGreatApi\Access\Models\Role as RoleModel;

class Role
{
    /**
     * Undocumented function
     *
     * @return RoleModel
     */
    private static function model(): RoleModel
    {
        return new RoleModel();
    }

    /**
     * Undocumented function
     *
     * @param callable $callback
     * @return void
     */
    public static function register(callable $callback): void
    {
        $callback(new Registrar(self::model()));
    }
}
