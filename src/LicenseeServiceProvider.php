<?php

namespace Rakshitbharat\Licensee;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;

class LicenseeServiceProvider extends ServiceProvider {

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(Router $router) {
        $router->aliasMiddleware('licensee', \Rakshitbharat\Licensee\Middleware\LicenseeMiddleware::class);

        $this->publishes([
            __DIR__ . '/Config/licensee.php' => config_path('licensee.php'),
                ], 'licensee_config');

        $this->loadRoutesFrom(__DIR__ . '/Routes/web.php');

        $this->loadMigrationsFrom(__DIR__ . '/Migrations');

        $this->loadViewsFrom(__DIR__ . '/Views', 'licensee');

        $this->publishes([
            __DIR__ . '/Views' => resource_path('views/vendor/licensee'),
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register() {
        $this->mergeConfigFrom(
                __DIR__ . '/Config/licensee.php', 'licensee'
        );
    }

}
