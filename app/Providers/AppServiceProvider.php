<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Additional service providers.
     *
     * @var array
     */
    protected $providers = [];

    /**
     * Register any application services.
     */
    public function register()
    {

        /**
         * Register additional service
         * providers if they exist.
         */
        foreach ($this->providers as $provider) {
            if (class_exists($provider)) {
                app()->register($provider);
            }
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        //
    }
}
