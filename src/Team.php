<?php

namespace LaravelGreatApi\Access;

use LaravelGreatApi\Access\Models\Team as TeamModel;

class Team
{
    /**
     * Undocumented function
     *
     * @return TeamModel
     */
    private static function model(): TeamModel
    {
        return new TeamModel();
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
