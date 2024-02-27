<?php

namespace App\Services;

use App\Repositories\DriverRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class DriverService
{
    private $repository;

    public function __construct(DriverRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function createDriver(array $data)
    {
        $user = Auth::user();

        $data['password'] = bcrypt($data['password']);
        $data['user_id'] = $user->id;

        $newDriver = $this->repository->createDriver($data);

        return $newDriver;
    }
}
