<?php

namespace App\Providers;

use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Illuminate\Support\ServiceProvider;

/**
 * Class AppServiceProvider
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class AppServiceProvider extends ServiceProvider
{

    /**
     * Additional service providers.
     *
     * @var array
     */
    protected $providers = [
        IdeHelperServiceProvider::class
    ];

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
