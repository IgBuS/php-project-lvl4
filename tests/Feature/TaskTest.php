<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\TaskStatus;
use App\Models\User;
use App\Models\Task;
use Database\Seeders\TaskStatusSeeder;
use Illuminate\Support\Facades\Auth;

class TaskFactoryTest extends TestCase
{
    use RefreshDatabase;
 
    /**
     * Test creating a new order.
     *
     * @return void
     */

    protected function setUp(): void
    {
        parent::setUp();


        $tasks = Task::factory()
                    ->count(3)
                    ->for(User::factory()->make(), 'created_by')
                    ->for(TaskStatus::factory()->make(), 'status')
                    ->make();
    }

    public function testIndex()
    {
        $response = $this->get(route('tasks.index'));
        $response->assertOk();
    }

    public function testCreate()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get(route('tasks.create'));
        $response->assertOk();
    }

    public function testEditWithoutAuth()
    {   
        $task = Task::factory()
            ->for(User::factory()->create(), 'created_by')
            ->for(TaskStatus::factory()->create(), 'status')
            ->create();
        $response = $this->get(route('tasks.edit', $task));
        $response->assertForbidden();
    }

    public function testEditWithAuth()
    {
        $user = User::factory()->create();
        $task = Task::factory()
        ->for(User::factory()->create(), 'created_by')
        ->for(TaskStatus::factory()->create(), 'status')
        ->create();
        $response = $this->actingAs($user)->get(route('tasks.edit', [$task]));
        $response->assertOk();
    }

    public function testStore()
    {
        $user = User::factory()->create();
        $data = Task::factory()
        ->for($user, 'created_by')
        ->for(TaskStatus::factory()->create(), 'status')
        ->raw();
        $response = $this->actingAs($user)->post(route('tasks.store'), $data);
        $response->assertRedirect(route('tasks.index'));
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('tasks', $data);
    }

    public function testUpdate()
    {
        $user = User::factory()->create();

        $task = Task::factory()
        ->for($user, 'created_by')
        ->for(TaskStatus::factory()->create(), 'status')
        ->create();

        $data = Task::factory()
        ->for($user, 'created_by')
        ->for(TaskStatus::factory()->create(), 'status')
        ->raw();


        $response = $this->actingAs($user)->patch(route('tasks.update', $task), $data);
        $response->assertRedirect(route('tasks.index'));
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('tasks', $data);
    }

    public function testUpdateWithoutAuth()
    {
        $user = User::factory()->create();

        $task = Task::factory()
        ->for($user, 'created_by')
        ->for(TaskStatus::factory()->create(), 'status')
        ->create();

        $data = Task::factory()
        ->for($user, 'created_by')
        ->for(TaskStatus::factory()->create(), 'status')
        ->raw();


        $response = $this->patch(route('tasks.update', $task), $data);
        $response->assertForbidden();

        $this->assertDatabaseMissing('tasks', $data);
    }

    public function testDestroy()
    {
        $user = User::factory()->create();

        $task = Task::factory()
        ->for($user, 'created_by')
        ->for(TaskStatus::factory()->create(), 'status')
        ->create();
        $response = $this->actingAs($user)->delete(route('tasks.destroy', $task));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('tasks.index'));

        $this->assertDatabaseMissing('tasks', $task->only('id'));
    }

    public function testDestroyByWrongUser()
    {
        $user = User::factory()->create();

        $wrongUser = User::factory()->create();

        $task = Task::factory()
        ->for($user, 'created_by')
        ->for(TaskStatus::factory()->create(), 'status')
        ->create();
        $response = $this->actingAs($wrongUser)->delete(route('tasks.destroy', $task));
        $response->assertForbidden();

        $this->assertDatabaseHas('tasks', $task->toArray());
    }
}
