<?php

namespace App\Repositories;

use App\Repositories\Interfaces\BaseRepositoryInterface;

abstract class BaseRepository implements BaseRepositoryInterface
{
    protected $model;

    public function all(): array
    {
        return $this->model->all()->toArray();
    }

    public function findOrFail(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function delete(int $id)
    {
        return $this->model->destroy($id);
    }
}
