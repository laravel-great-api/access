<?php

namespace LaravelGreatApi\Access;

class Access
{
    private static function permissionsRegistrar()
    {
        return new (Config::get('permissions_registrar_class'));
    }

    private static function teamsRegistrar()
    {
        return new (Config::get('teams_registrar_class'));
    }

    private static function rolesRegistrar()
    {
        return new (Config::get('roles_registrar_class'));
    }

    public static function refresh()
    {
        Permission::register(function(Registrar $registrar) {
            self::permissionsRegistrar()->register($registrar);
        });

        Team::register(function(Registrar $registrar) {
            self::teamsRegistrar()->register($registrar);
        });

        Role::register(function(Registrar $registrar) {
            self::rolesRegistrar()->register($registrar);
        });
    }
}
