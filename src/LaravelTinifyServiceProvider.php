<?php

namespace Jargoud\LaravelTinify;

use Illuminate\Support\ServiceProvider;
use Jargoud\LaravelTinify\Services\TinifyService;

class LaravelTinifyServiceProvider extends ServiceProvider
{
    protected const CONFIG_PATH = __DIR__ . '/../config/tinify.php';

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register custom form macros on package start
     * @return void
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
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(self::CONFIG_PATH, 'tinify');

        $this->app->bind('tinify', TinifyService::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
