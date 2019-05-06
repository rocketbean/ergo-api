<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ErgoServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        app()->singleton('ergo', function () {
            return new \App\Services\ErgoService;
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
