<?php

namespace EscolaLms\Cmi5;

use EscolaLms\Cmi5\Providers\AuthServiceProvider;
use EscolaLms\Cmi5\Services\Cmi5Service;
use EscolaLms\Cmi5\Services\Contracts\Cmi5ServiceContract;
use Illuminate\Support\ServiceProvider;

class EscolaLmsCmi5ServiceProvider extends ServiceProvider
{
    const CONFIG_KEY = 'escolalms_cmi5';

    public $singletons = [
        Cmi5ServiceContract::class => Cmi5Service::class,
    ];

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config.php', self::CONFIG_KEY);

        $this->app->register(AuthServiceProvider::class);
    }

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes.php');

        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    public function bootForConsole()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->publishes([
            __DIR__ . '/config.php' => config_path(self::CONFIG_KEY . '.php'),
        ], self::CONFIG_KEY . '.config');
    }
}
