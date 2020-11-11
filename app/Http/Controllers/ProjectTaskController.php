<?php

namespace App\Http\Controllers;

use Gate;
use App\Models\User;
use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProjectTaskController extends Controller
{
    public function store(Project $project)
    {
        request()->validate(['body' => 'required']);
        
        $this->authorize('update', $project);

        $project->addTask(request('body'));

        return redirect($project->path());
    }

    public function update(Project $project, Task $task)
    {        
        $this->authorize('update', $task->project);
        
        $attributes = request()->validate(['body' => 'required']);

        $task->update($attributes);
        
        request('completed') ? $task->complete() : $task->incomplete();

        return redirect($project->path());
    }

    public function destroy(Project $project, Task $task)
    {
        $task->delete();

        return redirect($project->fresh()->path());
    }
}
