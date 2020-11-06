<?php

namespace App\Providers;

use App\Models\Task;
use App\Models\Project;

use App\Observers\TaskObserver;
use App\Observers\ProjectObserver;

use Illuminate\Support\ServiceProvider;

class ObserverServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Task::observe(TaskObserver::class);
        Project::observe(ProjectObserver::class);
    }
}
