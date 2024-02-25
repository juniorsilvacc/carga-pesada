<?php

namespace App\Repositories;

interface UserRepositoryInterface
{
    public function getPaginate($name = null, $perPage = 5);

    public function createUser(array $data);

    public function getById(string $userId);
}
