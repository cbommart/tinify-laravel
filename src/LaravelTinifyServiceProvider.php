<?php

namespace Jargoud\LaravelTinify;

use Illuminate\Support\ServiceProvider;
use Jargoud\LaravelTinify\Services\TinifyService;

class LaravelTinifyServiceProvider extends ServiceProvider
{
    protected const CONFIG_PATH = __DIR__ . '/../config/tinify.php';

    /**
     * Indicates if loading of the provider is deferred.
     */
    protected bool $defer = false;

    /**
     * Register custom form macros on package start
     */
    public function boot(): void
    {
        $this->publishes(
            [self::CONFIG_PATH => config_path('tinify.php')],
            'config'
        );
    }

    /**
     * Register the service provider.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(self::CONFIG_PATH, 'tinify');

        $this->app->bind('tinify', TinifyService::class);
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return [];
    }
}
