<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\TaskStatus;
use App\Models\Task;
use App\Models\User;
use App\Models\Label;

class LabelFactoryTest extends TestCase
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
        Label::factory()->count(2)->make();
    }

    public function testIndex()
    {
        $response = $this->get(route('labels.index'));
        $response->assertOk();
    }

    public function testCreate()
    {
        $response = $this->get(route('labels.create'));
        $response->assertForbidden();
    }

    public function testEditWithoutAuth()
    {
        $label = Label::factory()->create();
        $response = $this->get(route('labels.edit', $label));
        $response->assertForbidden();
    }

    public function testEditWithAuth()
    {
        $user = User::factory()->create();
        $label = Label::factory()->create();
        $response = $this->actingAs($user)->get(route('labels.edit', $label));
        $response->assertOk();
    }

    public function testStore()
    {
        $user = User::factory()->create();
        $data = Label::factory()->raw();
        $response = $this->actingAs($user)->post(route('labels.store'), $data);
        $response->assertRedirect(route('labels.index'));
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('labels', $data);
    }

    public function testUpdate()
    {
        $label = Label::factory()->create();
        $data = Label::factory()->raw();

        $user = User::factory()->create();

        $response = $this->actingAs($user)->patch(route('labels.update', $label), $data);
        $response->assertRedirect(route('labels.index'));
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('labels', $data);
    }

    public function testDestroy()
    {
        $user = User::factory()->create();

        $label = Label::factory()->create();
        $response = $this->actingAs($user)->delete(route('labels.destroy', $label));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('labels.index'));

        $this->assertDatabaseMissing('labels', $label->only('id'));
    }

    public function testDestroyWithActiveTask()
    {
        $user = User::factory()->create();
        $status = TaskStatus::factory()->create();
        $label = Label::factory()->create();

        $this->assertDatabaseHas('labels', $label->toArray());

        $task = Task::factory()
        ->for($user, 'createdBy')
        ->for($status, 'status')
        ->hasAttached($label)
        ->create();

        $response = $this->actingAs($user)->delete(route('labels.destroy', $label));
        $response->assertRedirect(route('labels.index'));

        $this->assertDatabaseHas('labels', $label->toArray());
    }
}
