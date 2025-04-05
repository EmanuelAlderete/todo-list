<?php

namespace App\Repositories\Interfaces;

interface BaseRepositoryInterface
{
    public function all(): array;
    public function findOrFail(int $id);
    public function create(array $data);
    public function delete(int $id);
}
