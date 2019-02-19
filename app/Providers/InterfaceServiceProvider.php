<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class InterfaceServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind("App\Interfaces\EloquentServiceInterface", "App\Services\EloquentService");
        $this->app->bind("App\Interfaces\TagServiceInterface", "App\Services\TagService");
        $this->app->bind("App\Interfaces\TaskServiceInterface", "App\Services\TaskService");
    }
}
