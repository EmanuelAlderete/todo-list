<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskApiTest extends TestCase
{
    // Apaga o banco de dados e recria as tabelas
    // antes de cada teste
    use RefreshDatabase;

    // Cria um usuário e faz o login
    protected function authenticated()
    {
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');
    }

    public function test_fail_not_authenticated_user_cannot_create_task(): void
    {
        $taskList = \App\Models\TaskList::factory()->create();

        $response = $this->postJson('/api/task', [
            'text' => 'My Task',
            'labels' => ['label1', 'label2'],
            'status' => 'pending',
            'priority' => true,
            'task_list_id' => $taskList->id,
        ]);

        $response->assertStatus(401);
    }

    public function test_fail_create_task_missing_required_data(): void
    {
        $this->authenticated();

        $response = $this->postJson('/api/task', [
            'some_data' => 'Some value',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['text', 'task_list_id']);
    }

    public function test_fail_create_task_with_invalid_data(): void
    {
        $this->authenticated();

        $payload = [
            // 'task_list_id' está ausente
            'text' => '', // obrigatório e não pode ser string vazia
            'labels' => 'não é array', // tipo inválido
            'status' => 123, // deve ser string
            'priority' => 'alta', // deve ser booleano
        ];

        $response = $this->postJson('/api/task', $payload);

        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'task_list_id',
                'text',
                'labels',
                'status',
                'priority',
            ]);
    }

    public function test_create_task(): void
    {
        $this->authenticated();

        $taskList = \App\Models\TaskList::factory()->create();

        $payload = [
            'text' => 'My Task',
            'labels' => ['label1', 'label2'],
            'status' => 'pending',
            'priority' => true,
            'task_list_id' => $taskList->id,
        ];

        $response = $this->postJson('/api/task', $payload);

        $response->assertStatus(201)
            ->assertJson([
                'status' => 'success',
                'data' => [
                    'text' => 'My Task',
                    'labels' => ['label1', 'label2'],
                    'status' => 'pending',
                    'priority' => true,
                    // Verifica se o ID da lista de tarefas está correto
                    'task_list_id' => $taskList->id,
                ],
            ]);

        // Verifica se a tarefa foi criada no banco de dados
        $this->assertDatabaseHas('tasks', [
            'text' => 'My Task',
            'labels' => json_encode(['label1', 'label2']),
            'status' => 'pending',
            'priority' => true,
            // Verifica se o ID da lista de tarefas está correto
            'task_list_id' => $taskList->id,
        ]);
    }

    public function test_get_all_tasks(): void
    {
        $this->authenticated();

        $taskList = \App\Models\TaskList::factory()->create();

        $task1 = \App\Models\Task::factory()->create([
            'text' => 'Task 1',
            'labels' => ['label1'],
            'status' => 'pending',
            'priority' => true,
            'task_list_id' => $taskList->id,
        ]);

        $task2 = \App\Models\Task::factory()->create([
            'text' => 'Task 2',
            'labels' => ['label2'],
            'status' => 'completed',
            'priority' => false,
            'task_list_id' => $taskList->id,
        ]);

        $response = $this->getJson('/api/task');

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'data' => [
                    [
                        'text' => 'Task 1',
                        'labels' => ['label1'],
                        'status' => 'pending',
                        'priority' => true,
                        'task_list_id' => $taskList->id,
                    ],
                    [
                        'text' => 'Task 2',
                        'labels' => ['label2'],
                        'status' => 'completed',
                        'priority' => false,
                        'task_list_id' => $taskList->id,
                    ],
                ],
            ]);
    }

    public function test_update_task(): void
    {
        $this->authenticated();

        $taskList = \App\Models\TaskList::factory()->create();

        $task = \App\Models\Task::factory()->create([
            'text' => 'Old Task',
            'labels' => ['old_label'],
            'status' => 'pending',
            'priority' => false,
            'task_list_id' => $taskList->id,
        ]);

        $payload = [
            'text' => 'Updated Task',
            'labels' => ['new_label'],
            'status' => 'completed',
            'priority' => true,
            'task_list_id' => $taskList->id,
        ];

        $response = $this->putJson('/api/task/' . $task->id, $payload);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'data' => [
                    'text' => 'Updated Task',
                    'labels' => ['new_label'],
                    'status' => 'completed',
                    'priority' => true,
                    'task_list_id' => $taskList->id,
                ],
            ]);


        $this->assertDatabaseHas('tasks', [
            'text' => 'Updated Task',
            'labels' => json_encode(['new_label']),
            'status' => 'completed',
            'priority' => true,
            'task_list_id' => $taskList->id,
        ]);
    }

    public function test_delete_task(): void
    {
        $this->authenticated();

        $taskList = \App\Models\TaskList::factory()->create();

        $task = \App\Models\Task::factory()->create([
            'text' => 'Task to be deleted',
            'labels' => ['label'],
            'status' => 'pending',
            'priority' => false,
            'task_list_id' => $taskList->id,
        ]);

        $response = $this->deleteJson('/api/task/' . $task->id);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'message' => 'Task deleted successfully',
            ]);

        $this->assertDatabaseMissing('tasks', [
            'id' => $task->id,
        ]);
    }

    public function test_find_task(): void
    {
        $this->authenticated();

        $taskList = \App\Models\TaskList::factory()->create();

        $task = \App\Models\Task::factory()->create([
            'text' => 'Task to be found',
            'labels' => ['label'],
            'status' => 'pending',
            'priority' => false,
            'task_list_id' => $taskList->id,
        ]);

        $response = $this->getJson('/api/task/' . $task->id);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
                'data' => [
                    'text' => 'Task to be found',
                    'labels' => ['label'],
                    'status' => 'pending',
                    'priority' => false,
                    'task_list_id' => $taskList->id,
                ],
            ]);
    }

    public function test_user_cannot_access_other_users_tasks(): void
    {
        $userA = User::factory()->create();
        $userB = User::factory()->create();

        $taskList = \App\Models\TaskList::factory()->create([
            'user_id' => $userA->id,
        ]);

        $task = \App\Models\Task::factory(10)->create([
            'task_list_id' => $taskList->id,
        ]);

        $this->actingAs($userB, 'sanctum');

        $response = $this->getJson('/api/task/' . $task[0]->id)
            ->assertStatus(403);
    }
}
