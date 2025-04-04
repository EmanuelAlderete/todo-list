<?php

namespace App\Repositories;

use App\Models\TaskList;
use App\Repositories\Interfaces\TaskListRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class TaskListRepository implements TaskListRepositoryInterface
{
    public function create(array $data): TaskList
    {
        return TaskList::create($data);
    }

    public function findById(string $id): ?TaskList
    {
        return TaskList::where('id', $id)->first();
    }

    public function getAll(): ?array
    {
        return TaskList::all()->toArray();
    }
}
