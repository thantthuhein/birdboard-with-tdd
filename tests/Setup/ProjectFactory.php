<?php

namespace Tests\Setup;

use App\Models\User;
use App\Models\Task;
use App\Models\Project;

class ProjectFactory {
     protected $user;

     protected  $tasksCount = 0;

     public function create()
     {
          $project = Project::factory()->create([
               'owner_id' => $this->user ?? User::factory()->create()->id
          ]);

          Task::factory()->count($this->tasksCount)->create([
               'project_id' => $project->id
          ]);

          return $project;
     }

     public function ownedBy($user)
     {
          $this->user = $user;

          return $this;
     }

     public function withTasks($count)
     {
          $this->tasksCount = $count;

          return $this;
     }
}