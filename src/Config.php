<?php

namespace LaravelGreatApi\Access;

use Illuminate\Support\Facades\Config as ConfigFacade;

class Config
{
    public static function get(string $key)
    {
        return ConfigFacade::get("laravel-great-api.$key");
    }
}
