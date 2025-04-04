<?php

namespace App\Providers;

use App\Repositories\Interfaces\TaskListRepositoryInterface;
use App\Repositories\TaskListRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(TaskListRepositoryInterface::class, TaskListRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
