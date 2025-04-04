<?php

namespace App\Repositories\Interfaces;

use App\Models\TaskList;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface TaskListRepositoryInterface
{
    public function create(array $data): TaskList;
    public function findById(string $id): ?TaskList;
    public function getAll(): ?array;
}
