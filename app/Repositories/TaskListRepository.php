<?php

namespace App\Repositories;

use App\Models\TaskList;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\TaskRepositoryInterface;

class TaskListRepository extends BaseRepository implements TaskRepositoryInterface
{
    public function __construct(TaskList $model)
    {
        $this->model = $model;
    }
}
