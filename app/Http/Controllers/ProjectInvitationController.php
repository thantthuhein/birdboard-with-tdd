<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectInvitationController extends Controller
{
    public function store(Project $project)
    {
        request()->validate([
            'email' => 'exists:users,email'
        ], [
            'email.exists' => 'The invited user must have a account.'
        ]);

        $user = User::whereEmail(request('email'))->first();

        $project->invite($user);
    }
}
