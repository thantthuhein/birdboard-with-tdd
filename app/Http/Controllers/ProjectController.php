<?php

namespace App\Http\Controllers;

use Gate;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateProjectRequest;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = auth()->user()->relatedProjects();
        
        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function show(Project $project)
    {        
        $this->authorize('update', $project);

        return view('projects.show', compact('project'));
    }

    public function store()
    {
        $project = auth()->user()->projects()->create($this->validateRequest());    

        $tasks = collect(request('tasks'))->whereNotNull('body')->all();
        
        if (! empty($tasks)) {
            $project->addManyTasks($tasks);
        }

        if (request()->wantsJson()) return ['message' => $project->path()];

        return redirect($project->path());
    }

    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    public function update(Project $project)
    {
        $this->authorize('update', $project);

        $project->update($this->validateRequest());

        return redirect($project->path());
    }
    // public function update(UpdateProjectRequest $form)
    // {
    //     // Form Object Style
    //     return redirect($form->save()->path());
    // }

    public function destroy(Project $project)
    {
        $this->authorize('manage', $project);

        $project->delete();

        return redirect('/projects');
    }

    public function validateRequest()
    {
        return request()->validate([
            'title' => 'sometimes|required',
            'description' => 'sometimes|required',
            'notes' => 'max:255',
        ]);
    }
}
