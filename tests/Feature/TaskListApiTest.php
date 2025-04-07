<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskListApiTest extends TestCase
{
    use RefreshDatabase;

    protected function authenticated()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');
    }

    public function test_create_task_list_with_valid_data(): void
    {
        $this->authenticated();

        $response = $this->postJson('/api/task-list', [
            'title' => 'My Task List',
        ]);

        $response->assertStatus(201)
            ->assertJsonFragment([
                'title' => 'My Task List',
            ]);

        $this->assertDatabaseHas('task_lists', ['title' => 'My Task List']);
    }

    public function test_create_task_list_missing_required_data(): void
    {
        $this->authenticated();

        $response = $this->postJson('/api/task-list', [
            'some_data' => 'Some value',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['title']);
    }

    public function test_not_authenticated_user_cannot_create_task_list(): void
    {
        $response = $this->postJson('/api/task-list', [
            'title' => 'My Task List',
        ]);
        $response->assertStatus(401);
    }

    public function test_get_all_task_lists(): void
    {
        $this->authenticated();

        $response = $this->getJson('/api/task-list');
        $response->assertStatus(200);
    }

    public function test_update_task_list(): void
    {
        $this->authenticated();

        $taskList = \App\Models\TaskList::factory()->create([
            'title' => 'Old Title',
        ]);

        $response = $this->putJson('/api/task-list/' . $taskList->id, [
            'title' => 'New Title',
        ]);
        $response->assertStatus(200)
            ->assertJsonFragment([
                'title' => 'New Title',
            ]);
        $this->assertDatabaseHas('task_lists', ['title' => 'New Title']);
    }

    public function test_delete_task_list(): void
    {
        $this->authenticated();

        $taskList = \App\Models\TaskList::factory()->create([
            'title' => 'My Task List',
        ]);

        $response = $this->deleteJson('/api/task-list/' . $taskList->id);
        $response->assertStatus(200);
        $this->assertDatabaseMissing('task_lists', ['title' => 'My Task List']);
    }

}
