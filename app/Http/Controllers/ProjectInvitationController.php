<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Requests\ProjectInvitationRequest;

class ProjectInvitationController extends Controller
{
    /**
     * Update the project by inviting a user
     * 
     * @param App\Models\Project $project
     */
    public function store(Project $project, ProjectInvitationRequest $request)
    {
        $this->authorize('update', $project);

        $user = User::whereEmail(request('email'))->first();

        $project->invite($user);

        return redirect($project->path());
    }
}
