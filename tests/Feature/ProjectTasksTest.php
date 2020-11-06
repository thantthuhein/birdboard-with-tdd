<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTasksTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function guest_cannot_add_tasks_to_a_project()
    {
        $project = ProjectFactory::create();

        $this->post($project->path() . '/tasks')->assertRedirect('login');
    }

    /** @test */
    public function a_project_can_have_tasks()
    {
        $this->withoutExceptionHandling();

        $project = ProjectFactory::create();

        $this->actingAs($project->owner)->post($project->path() . '/tasks', ['body' => 'Test task'])
            ->assertRedirect($project->path());

        $this->get($project->path())->assertSee('Test task');
    }

    /** @test */
    public function a_task_can_be_updated()
    {
        $this->withoutExceptionHandling();
        
        $project = ProjectFactory::withTasks(1)->create();

        $this->actingAs($project->owner)->patch($project->tasks[0]->path(), [
            'body' => 'updated',
        ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'updated',
        ]);
    }

    /** @test */
    public function a_task_can_be_completed()
    {
        $this->withoutExceptionHandling();
        
        $project = ProjectFactory::withTasks(1)->create();

        $this->actingAs($project->owner)->patch($project->tasks[0]->path(), [
            'body' => 'updated',
            'completed' => true
        ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'updated',
            'completed' => true
        ]);
    }

    /** @test */
    public function a_task_can_be_mark_as_incompleted()
    {
        $project = ProjectFactory::withTasks(1)->create();

        $this->actingAs($project->owner)->patch($project->tasks[0]->path(), [
            'body' => 'updated' . $project->id,
            'completed' => true
        ]);

        $this->actingAs($project->owner)->patch($project->tasks[0]->path(), [
            'body' => 'updated: assert false',
            'completed' => false
        ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'updated: assert false',
            'completed' => false
        ]);
    }

    /** @test */
    public function only_the_owner_of_the_project_can_add_tasks()
    {
        // $this->withoutExceptionHandling();
        $project = ProjectFactory::create();

        $this->signIn();

        $this->post($project->path() . '/tasks', ['body' => 'Testing Task'])
            ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'Testing Task']);
    }

    /** @test */
    public function only_the_owner_of_the_project_can_update_a_task()
    {
        // $this->withoutExceptionHandling();
        
        $this->signIn();

        $project = ProjectFactory::withTasks(1)->create();

        $this->patch($project->tasks[0]->path(), ['body' => 'updated'])
            ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'updated']);
    }

    /** @test */
    public function a_task_requires_a_body()
    {
        $project = ProjectFactory::ownedBy($this->signIn())->create();

        $task = Task::factory()->raw(['body' => '']);

        $this->actingAs($project->owner)
            ->post($project->path() . '/tasks', $task)
            ->assertSessionHasErrors('body');
    }
}
