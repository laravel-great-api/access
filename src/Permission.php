<?php

namespace LaravelGreatApi\Access;

use LaravelGreatApi\Access\Models\Permission as PermissionModel;

class Permission
{
    /**
     * Undocumented function
     *
     * @return PermissionModel
     */
    private static function model(): PermissionModel
    {
        return new PermissionModel();
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
