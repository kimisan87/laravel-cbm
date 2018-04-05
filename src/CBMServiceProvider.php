<?php

namespace MohdNazrul\CBMLaravel;

use Illuminate\Support\ServiceProvider;

class CBMServiceProvider extends ServiceProvider
{
    protected $defer = true;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/cbm.php' => config_path('cbm.php'),
        ], 'cbm');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/cbm.php','cbm');

        $this->app->singleton('CBMApi', function ($app){
            $config     =   $app->make('config');
            $username   =   $config->get('cbm.username');
            $password   =   $config->get('cbm.password');
            $serviceURL =   $config->get('cbm.serviceUrl');

            return new CBMApi($username, $password, $serviceURL);

        });
    }

    public function provides() {
        return ['CBMApi'];
    }
}
