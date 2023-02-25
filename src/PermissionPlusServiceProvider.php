<?php

namespace Laraditz\PermissionPlus;

use Illuminate\Foundation\Console\AboutCommand;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laraditz\PermissionPlus\Console\GeneratePermissionPlusCommand;
use Laraditz\PermissionPlus\Http\Middleware\PermissionPlus as PermissionPlusMiddleware;

class PermissionPlusServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {

        // AboutCommand::add('Laravel Permission Plus', fn () => ['Version' => '1.0.0']);
        /*
         * Optional methods to load your package assets
         */
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'permission-plus');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'permission-plus');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->registerRoutes();

        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('permission.plus', PermissionPlusMiddleware::class);

        if (config('permission-plus.global_middleware')) {
            $this->app->booted(function () use ($router) {
                $router->pushMiddlewareToGroup('web', PermissionPlusMiddleware::class);
                $router->pushMiddlewareToGroup('api', PermissionPlusMiddleware::class);
            });
        }


        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/config.php' => config_path('permission-plus.php'),
            ], 'config');

            // Publishing the views.
            /*$this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/permission-plus'),
            ], 'views');*/

            // Publishing assets.
            /*$this->publishes([
                __DIR__.'/../resources/assets' => public_path('vendor/permission-plus'),
            ], 'assets');*/

            // Publishing the translation files.
            /*$this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/permission-plus'),
            ], 'lang');*/

            // Registering package commands.
            $this->commands([
                GeneratePermissionPlusCommand::class
            ]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'permission-plus');

        // Register the main class to use with the facade
        $this->app->singleton('permission-plus', function () {
            return new PermissionPlus;
        });
    }

    protected function registerRoutes()
    {
        Route::group($this->routeConfiguration(), function () {
            Route::name($this->routeConfiguration()['prefix'] . '.')->group(function () {
                $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
            });
        });
    }

    protected function routeConfiguration()
    {
        return [
            'prefix' => config('permission-plus.prefix'),
            'middleware' => config('permission-plus.middleware'),
        ];
    }
}
