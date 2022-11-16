<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\TaskStatus;
use App\Models\Task;
use App\Models\User;

class TaskStatusFactoryTest extends TestCase
{
    /**
     * Test creating a new order.
     *
     * @return void
     */

    protected function setUp(): void
    {
        parent::setUp();
        TaskStatus::factory()->count(2)->make();
    }

    public function testIndex()
    {
        $response = $this->get(route('task_statuses.index'));
        $response->assertOk();
    }

    public function testCreate()
    {
        $response = $this->get(route('task_statuses.create'));
        $response->assertOk();
    }

    public function testEditWithoutAuth()
    {
        $status = TaskStatus::factory()->create();
        $response = $this->get(route('task_statuses.edit', $status));
        $response->assertForbidden();
    }

    public function testEditWithAuth()
    {
        $user = User::factory()->create();
        $status = TaskStatus::factory()->create();
        $response = $this->actingAs($user)->get(route('task_statuses.edit', $status));
        $response->assertOk();
    }

    public function testStore()
    {
        $data = TaskStatus::factory()->raw();
        $response = $this->post(route('task_statuses.store'), $data);
        $response->assertRedirect(route('task_statuses.index'));
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('task_statuses', $data);
    }

    public function testUpdate()
    {
        $status = TaskStatus::factory()->create();
        $data = TaskStatus::factory()->raw();

        $user = User::factory()->create();

        $response = $this->actingAs($user)->patch(route('task_statuses.update', $status), $data);
        $response->assertRedirect(route('task_statuses.index'));
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('task_statuses', $data);
    }

    public function testDestroy()
    {
        $user = User::factory()->create();

        $status = TaskStatus::factory()->create();
        $response = $this->actingAs($user)->delete(route('task_statuses.destroy', $status));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('task_statuses.index'));

        $this->assertDatabaseMissing('task_statuses', $status->only('id'));
    }

    public function testDestroyWithActiveTask()
    {
        $user = User::factory()->create();
        $status = TaskStatus::factory()->create();

        $this->assertDatabaseHas('task_statuses', $status->toArray());

        $task = Task::factory()
            ->for($user, 'createdBy')
            ->for($status, 'status')
            ->create();

        $response = $this->actingAs($user)->delete(route('task_statuses.destroy', $status));
        $response->assertRedirect(route('task_statuses.index'));

        $this->assertDatabaseHas('task_statuses', $status->toArray());
    }
}
