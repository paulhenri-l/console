<?php

namespace PHLConsole\Providers;

use Illuminate\Support\ServiceProvider;

class CommandsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Check if we are in an engine
        // If we are load the required commands
        // If we are not remove unneded commands
        // If we are in an app act acordingly
    }
}
