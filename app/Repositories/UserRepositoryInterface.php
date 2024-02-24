<?php

namespace App\Repositories;

interface UserRepositoryInterface
{
    public function getPaginate($name = null, $perPage = 5);
}
