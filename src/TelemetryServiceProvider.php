<?php

declare(strict_types = 1);

namespace Centrex\Telemetry;

use Illuminate\Support\ServiceProvider;

class TelemetryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'laravel-telemetry');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'laravel-telemetry');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/config.php' => config_path('laravel-telemetry.php'),
            ], 'laravel-telemetry-config');

            // Publishing the migrations.
            /*$this->publishes([
                __DIR__.'/../database/migrations/' => database_path('migrations')
            ], 'laravel-telemetry-migrations');*/

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/laravel-telemetry'),
            ], 'laravel-telemetry-views');*/

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/laravel-telemetry'),
            ], 'laravel-telemetry-assets');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/laravel-telemetry'),
            ], 'laravel-telemetry-lang');*/

            // Registering package commands.
            // $this->commands([]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'laravel-telemetry');

        // Register the main class to use with the facade
        $this->app->singleton('laravel-telemetry', function () {
            return new Telemetry();
        });
    }
}
