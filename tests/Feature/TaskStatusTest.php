<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\TaskStatus;
use App\Models\User;
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
        Auth::logout();
        $status = TaskStatus::factory()->create();
        $response = $this->get(route('task_statuses.edit', [$status]));
        $response->assertUnauthorized();
    }

    public function testEditWithAuth()
    {
        $user = User::factory()->create();
        $status = TaskStatus::factory()->create();
        $response = $this->actingAs($user)->get(route('task_statuses.edit', [$status]));
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
        $response = $this->actingAs($user)->delete(route('task_statuses.destroy', $status['id']));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('task_statuses.index'));

        $this->assertDatabaseMissing('task_statuses', $status->only('id'));
    }
}
