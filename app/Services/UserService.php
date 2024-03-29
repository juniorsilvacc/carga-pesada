<?php

namespace App\Services;

use App\Repositories\UserRepositoryInterface;

class UserService
{
    private $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getPaginate($nome = null, $cpf = null)
    {
        $users = $this->repository->getPaginate($nome, $cpf);

        return $users;
    }

    public function getById($userId)
    {
        $user = $this->repository->getById($userId);

        return $user;
    }

    public function createUser(array $data)
    {
        $newUser = $this->repository->createUser($data);

        return $newUser;
    }

    public function updateUser(array $data, string $userId)
    {
        $user = $this->repository->updateUser($data, $userId);

        return $user;
    }

    public function deleteUser(string $userId)
    {
        return $this->repository->deleteUser($userId);
    }

    public function syncPermissions(string $userId, array $permissions)
    {
        $permissionsUser = $this->repository->syncPermissions($userId, $permissions);

        return $permissionsUser;
    }
}
