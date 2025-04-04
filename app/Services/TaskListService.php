<?php

namespace App\Services;

use App\Repositories\Interfaces\TaskListRepositoryInterface;
use App\Models\TaskList;
use Illuminate\Database\Eloquent\Collection;

class TaskListService
{
    protected TaskListRepositoryInterface $taskListRepository;

    public function __construct(TaskListRepositoryInterface $taskListRepository)
    {
        $this->taskListRepository = $taskListRepository;
    }

    public function create(array $data): TaskList
    {
        return $this->taskListRepository->create($data);
    }

    public function findById(int $id): TaskList
    {
        return $this->taskListRepository->findById($id);
    }

    public function getAll(): ?array
    {
        return $this->taskListRepository->getAll();
    }
}
