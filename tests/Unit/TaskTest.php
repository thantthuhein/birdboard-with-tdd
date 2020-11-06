<?php

namespace Tests\Unit;

use App\Models\Task;
use App\Models\User;
use App\Models\Project;
// use PHPUnit\Framework\TestCase;
use Tests\TestCase;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @test */
    public function it_has_a_path()
    {        
        $task = Task::factory()->create(['body' => 'Test Task']);

        $this->assertEquals('/projects/' . $task->project->id . '/tasks/' . $task->id, $task->path());
    }

    /** @test */
    public function it_belongs_to_a_project()
    {
        $task = Task::factory()->create(['body' => 'Test Task']);

        $this->assertInstanceOf(Project::class, $task->project);
    }

    /** @test */
    public function it_can_be_completed()
    {
        $task = Task::factory()->create(['body' => 'Test Task']);
        
        $this->assertFalse($task->completed);
        
        $task->complete();

        $this->assertTrue($task->completed);
    }

    /** @test */
    public function it_can_be_incompleted()
    {
        $task = Task::factory()->create(['body' => 'Test Task']);

        $this->assertFalse($task->completed);

        $task->complete();

        $this->assertTrue($task->completed);
        
        $task->incomplete();

        $this->assertFalse($task->completed);
    }
}

