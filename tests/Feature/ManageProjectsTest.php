<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Project;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;
    
    /** @test */
    public function guests_cannot_manage_projects()
    {
        $project = Project::factory()->create();

        $this->get('/projects')->assertRedirect('login');
        $this->get('/projects/create')->assertRedirect('login');
        $this->get($project->path())->assertRedirect('login');
        $this->get($project->path() . '/edit')->assertRedirect('login');
        $this->patch($project->path())->assertRedirect('login');
        $this->post('/projects', $project->toArray())->assertRedirect('login');
        $this->delete($project->path())->assertRedirect('login');
    }

    /** @test */
    public function a_user_can_create_a_project()
    {
        $user = $this->signIn();

        $this->get('/projects/create')->assertStatus(200);

        $this->followingRedirects()
            ->post('/projects', $attributes = Project::factory()->raw(['owner_id' => $user->id]))
            ->assertSee($attributes['title'])
            ->assertSee($attributes['description'])
            ->assertSee($attributes['notes']);
    }

    /** @test */
    public function tasks_can_be_included_as_part_of_project_creation()
    {
        $this->withoutExceptionHandling();
        $user = $this->signIn();

        $attributes = Project::factory()->raw(['owner_id' => $user->id]);

        $attributes['tasks'] = [
            ['body' => 'task 1'],
            ['body' => 'task 2'],
            ['body' => 'task 3'],
        ];

        $this->post('/projects', $attributes);

        $this->assertCount(3, Project::first()->tasks);
    }

    /** @test */
    public function a_user_can_see_invited_projects_on_dashboard()
    {
        $project = tap(ProjectFactory::create())->invite($this->signIn());

        $this->get('/projects')->assertSee($project->title);
    }

    /** @test */
    public function a_user_can_delete_a_project()
    {
        $this->withoutExceptionHandling();
        $project = ProjectFactory::create();

        $this->actingAs($project->owner)
            ->delete($project->path())
            ->assertRedirect('/projects');

        $this->assertDatabaseMissing('projects', $project->only('id'));
    }

    /** @test */
    public function unathorized_user_cannot_delete_a_project()
    {
        $project = ProjectFactory::create();

        $this->signIn();

        $this->delete($project->path())->assertStatus(403);
    }

    /** @test */
    public function invited_user_cannot_delete_a_project()
    {
        $project = ProjectFactory::create();

        $user = $this->signIn();

        $this->actingAs($user)->delete($project->path())->assertStatus(403);
        
        $project->invite($user);

        $this->actingAs($user)->delete($project->path())->assertStatus(403);
    }

    /** @test */
    public function a_user_can_update_a_projects_general_notes()
    {
        $project = ProjectFactory::create();

        $this->actingAs($project->owner)
            ->patch($project->path(), $changedNote = ['notes' => 'Changes Completed'])
            ->assertRedirect($project->path());

        $this->assertDatabaseHas('projects', $changedNote);
    }

    /** @test */
    public function a_user_can_view_their_project(){        
        $project = ProjectFactory::create();

        $this->actingAs($project->owner)
            ->get($project->path())
            ->assertSee($project->title);
    }

    /** @test */
    public function a_user_cannot_view_others_project()
    {        
        $project = ProjectFactory::create(); // Others project
        
        $this->actingAs($this->signIn())->get($project->path())->assertStatus(403);
    }

    /** @test */
    public function a_user_can_update_a_project()
    {        
        $project = ProjectFactory::create();
        
        $this->actingAs($project->owner)
            ->patch($project->path(), ['notes' => 'Changed'])
            ->assertRedirect($project->path());

        $this->assertDatabaseHas('projects', ['notes' => 'Changed']);
    }

    /** @test */
    public function a_user_cannot_update_others_project()
    {        
        $this->signIn();

        $project = Project::factory()->create();
        
        $this->patch($project->path(), ['notes' => 'General Notes'])->assertStatus(403);
    }

    /** @test */
    public function a_project_requires_a_title()
    {
        $this->signIn();

        $attributes = Project::factory()->raw(['title' => '']);

        $this->post('/projects', $attributes)->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_project_requires_a_description()
    {
        $this->signIn();

        $attributes = Project::factory()->raw(['description' => '']);

        $this->post('/projects', $attributes)->assertSessionHasErrors('description');
    }
}
