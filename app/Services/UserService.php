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

    public function getPaginate($name = null)
    {
        $users = $this->repository->getPaginate($name);

        return $users;
    }

    public function show()
    {
    }

    public function store()
    {
    }

    public function update()
    {
    }

    public function destroy()
    {
    }
}
