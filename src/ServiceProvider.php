<?php

namespace LaravelGreatApi\Access;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use LaravelGreatApi\Access\Console\Commands\RefreshAccess;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->commands([RefreshAccess::class]);

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        //
    }
}
