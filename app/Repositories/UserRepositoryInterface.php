<?php

namespace App\Repositories;

interface UserRepositoryInterface
{
    public function getAllUsers($name = null, $perPage = 10);
}
