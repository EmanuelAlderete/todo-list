<?php

namespace App\Services;

use App\Models\TaskList;
use App\Repositories\TaskListRepository;

class TaskListService
{
    protected TaskListRepository $taskListRepository;

    public function __construct(TaskListRepository $taskListRepository)
    {
        $this->taskListRepository = $taskListRepository;
    }

    public function create(array $data)
    {
        return $this->taskListRepository->create($data);
    }

    public function findOrFail(int $id)
    {
        return $this->taskListRepository->findOrFail($id);
    }

    public function getAll(): ?array
    {
        return $this->taskListRepository->all();
    }

    public function update(int $id, array $data)
    {
        return $this->taskListRepository->update($id, $data);
    }
}
