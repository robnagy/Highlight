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
        $this->app->bind("App\Interfaces\SubtaskServiceInterface", "App\Services\SubtaskService");
        $this->app->bind("App\Interfaces\TagServiceInterface", "App\Services\TagService");
        $this->app->bind("App\Interfaces\TagTaskServiceInterface", "App\Services\TagTaskService");
        $this->app->bind("App\Interfaces\TaskServiceInterface", "App\Services\TaskService");
        $this->app->bind("App\Interfaces\UserServiceInterface", "App\Services\UserService");
    }
}
