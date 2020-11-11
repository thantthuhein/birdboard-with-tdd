<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Task;
use App\Models\Project;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InvitationTest extends TestCase
{
    use WithFaker, RefreshDatabase;
    
    /** @test */
    public function only_the_owenr_of_the_project_can_invite_a_user()
    {
        $project = ProjectFactory::create();

        $user = User::factory()->create();

        $assertInvitationForbidden = function() use ($user, $project) {
            $this->actingAs($user)->post($project->path() . '/invitations')->assertStatus(403);
        };
        
        $assertInvitationForbidden();

        $project->invite($user);

        $assertInvitationForbidden();
    }

    /** @test */
    public function a_project_owner_can_invite_a_user()
    {
        $project = ProjectFactory::create();

        $userToInvite = User::factory()->create();

        $this->actingAs($project->owner)
            ->post($project->path() . '/invitations', [
                'email' => $userToInvite->email
            ])
            ->assertRedirect($project->path());

        $this->assertTrue($project->members->contains($userToInvite));
    }

    /** @test */
    public function invited_email_must_be_birdboard_account()
    {
        // $this->withoutExceptionHandling();
        $project = ProjectFactory::create();

        $this->actingAs($project->owner)
            ->post($project->path() . '/invitations', [
                'email' => 'invalidemail@example.com'
            ])
            ->assertSessionHasErrors([
                'email' => 'The invited user must have an account.'
            ], null, 'invitations');
    }

    /** @test */
    public function invited_users_may_update_a_project()
    {
        $project = ProjectFactory::create();

        $project->invite($newUser = User::factory()->create());

        $this->actingAs($newUser)
            ->post($project->path() . '/tasks', $task = ['body' => 'Test Task']);

        $this->assertDatabaseHas('tasks', $task);
    }
}
