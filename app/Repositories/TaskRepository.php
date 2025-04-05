<?php

namespace App\Repositories;

use App\Models\Task;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\BaseRepositoryInterface;

class TaskRepository extends BaseRepository implements BaseRepositoryInterface
{
    public function __construct(Task $model)
    {
        $this->model = $model;
    }
}
