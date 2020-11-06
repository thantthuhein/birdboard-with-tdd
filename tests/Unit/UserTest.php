<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Project;
use Tests\TestCase;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function a_user_has_projects()
    {
        $user = User::factory()->create();

        $this->assertInstanceOf(Collection::class, $user->projects);
    }
    
    /** @test */
    public function a_user_has_related_projects_if_they_invited()
    {
        $john = $this->signIn();

        ProjectFactory::ownedBy($john)->create();
        
        $this->assertCount(1, $john->relatedProjects());

        $mary = User::factory()->create();
        $jack = User::factory()->create();
        
        $project = tap(ProjectFactory::ownedBy($mary)->create())->invite($jack);

        $this->assertCount(1, $john->relatedProjects());

        $project->invite($john);

        $this->assertCount(2, $john->relatedProjects());   
    }
}
