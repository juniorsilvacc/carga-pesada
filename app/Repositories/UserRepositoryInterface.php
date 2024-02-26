<?php

namespace App\Repositories;

interface UserRepositoryInterface
{
    public function getPaginate($name = null, $perPage = 5);

    public function createUser(array $data);

    public function getById(string $userId);

    public function updateUser(array $data, string $userId);

    public function deleteUser(string $userId);

    public function findByCpf(string $cpf);

    public function syncPermissions(string $userId, array $permissions): ?bool;
}
