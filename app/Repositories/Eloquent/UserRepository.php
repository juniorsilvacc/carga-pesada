<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    private $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function getPaginate($name = null, $perPage = 5)
    {
        $query = $this->model->orderBy('created_at', 'asc');

        if ($name !== null) {
            $query->where('name', 'LIKE', "%{$name}%");
        }

        $users = $query->paginate($perPage);

        return $users;
    }

    public function createUser(array $data)
    {
        $newUser = $this->model->create($data);

        return $newUser;
    }
}
