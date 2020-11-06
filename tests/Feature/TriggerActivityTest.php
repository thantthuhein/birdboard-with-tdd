<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Task;
use App\Models\Project;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TriggerActivityTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function creating_a_project()
    {
        $project = ProjectFactory::create();

        $this->assertCount(1, $project->activities);

        tap($project->activities->last(), function($activity) {
            $this->assertEquals('project_created', $activity->description);

            $this->assertNull($activity->changes);
        });          
    }

    /** @test */
    public function updating_a_project()
    {
        $project = ProjectFactory::create();
        $originalTitle = $project->title;

        $project->update(['title' => 'Changed']);

        $this->assertCount(2, $project->activities);

        tap($project->activities->last(), function($activity) use ($originalTitle) {
            $this->assertEquals('project_updated', $activity->description);

            $excepted = [
                'before' => ['title' => $originalTitle],
                'after' => ['title' => 'Changed'],
            ];

            $this->assertEquals($excepted, $activity->stateChanges);
        });
    }

    /** @test */
    public function creating_a_task()
    {
        $project = ProjectFactory::create();

        $project->addTask('Test Task');
        
        $this->assertCount(2, $project->activities);

        tap($project->activities->last(), function($activity) use ($project) {
            $this->assertEquals('task_created', $activity->description);
            $this->assertInstanceOf(Task::class, $activity->subject);
            $this->assertEquals($project->tasks->last()->id, $activity->subject->id);
        });

        $this->assertEquals('task_created', $project->activities->last()->description);
    }
    /** @test */
    public function completing_a_task()
    {
        $project = ProjectFactory::withTasks(1)->create();

        $this->actingAs($project->owner)->patch($project->tasks[0]->path(), [
            'body' => 'Changed',
            'completed' => true,
        ]);

        $this->assertCount(3, $project->activities);
        $this->assertEquals('task_completed', $project->activities->last()->description);
    }

    /** @test */
    public function incompleting_a_task()
    {
        $this->withoutExceptionHandling();
        $project = ProjectFactory::withTasks(1)->create();

        $this->actingAs($project->owner)->patch($project->tasks[0]->path(), [
            'body' => 'Changed',
            'completed' => true,
        ]);
        
        $this->assertCount(3, $project->activities);
        $this->assertEquals('task_completed', $project->activities->last()->description);

        $this->actingAs($project->owner)->patch($project->tasks[0]->path(), [
            'body' => 'Changed',
            'completed' => false,
        ]);
        
        // need to reload the $project->activities
        // can use $project->refresh();
        $this->assertCount(4, $activities = $project->fresh()->activities);
        $this->assertEquals('task_incompleted', $activities->last()->description);
    }

    /** @test */
    public function deleting_a_task()
    {
        $this->withoutExceptionHandling();
        $project = ProjectFactory::withTasks(1)->create();

        $this->actingAs($project->owner)->delete($project->tasks[0]->path());

        $project->refresh();

        $this->assertCount(0, $project->tasks);

        $this->assertCount(3, $project->activities);
        $this->assertEquals('task_deleted', $project->activities->last()->description);
    }
}
