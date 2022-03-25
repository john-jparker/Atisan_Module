<?php

namespace Rsruman\Brand\Providers;

use Illuminate\Support\ServiceProvider;

class BrandServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../Routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'Brand');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }
}
