<?php

namespace App\Providers;

use App\Observers\TaskObserver;
use App\Observers\TodoObserver;
use App\Observers\UserObserver;
use App\Task;
use App\Todo;
use App\User;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        User::observe(UserObserver::class);
        Todo::observe(TodoObserver::class);
        Task::observe(TaskObserver::class);

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
