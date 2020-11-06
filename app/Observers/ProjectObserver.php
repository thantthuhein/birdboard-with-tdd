<?php

namespace App\Observers;

use App\Models\Project;
use App\Models\Activity;

class ProjectObserver
{
    /**
     * Handle the project "created" event.
     *
     * @param  \App\Models\Project  $project
     * @return void
     */
    public function created(Project $project)
    {
        $project->recordActivity('project_created');
    }

    /**
     * Handle the project "updated" event.
     *
     * @param  \App\Models\Project  $project
     * @return void
     */
    public function updated(Project $project)
    {
        $project->recordActivity('project_updated');
    }
    // Events ==> created, updated, deleted, restored, forceDeleted
}
