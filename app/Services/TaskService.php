<?php

namespace App\Services;

use App\Models\TaskList;
use App\Repositories\TaskRepository;

class TaskService
{
    protected TaskRepository $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function create(array $data)
    {
        return $this->taskRepository->create($data);
    }

    public function findOrFail(int $id)
    {
        return $this->taskRepository->findOrFail($id);
    }

    public function all(): ?array
    {
        return $this->taskRepository->all();
    }

    public function update(int $id, array $data)
    {
        return $this->taskRepository->update($id, $data);
    }
}
