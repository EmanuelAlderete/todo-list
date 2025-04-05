<?php

namespace App\Repositories;

use App\Models\TaskList;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\BaseRepositoryInterface;

class TaskListRepository extends BaseRepository implements BaseRepositoryInterface
{
    public function __construct(TaskList $model)
    {
        $this->model = $model;
    }
}
