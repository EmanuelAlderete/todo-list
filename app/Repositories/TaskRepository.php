<?php

namespace App\Repositories;

use App\Models\Task;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\TaskRepositoryInterface;

class TaskRepository extends BaseRepository implements TaskRepositoryInterface
{
    public function __construct(Task $model)
    {
        $this->model = $model;
    }
}
