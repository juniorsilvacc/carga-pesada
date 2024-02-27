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

    public function getPaginate($nome = null, $cpf = null)
    {
        $drivers = $this->repository->getPaginate($nome, $cpf);

        return $drivers;
    }

    public function getById($driverId)
    {
        $driver = $this->repository->getById($driverId);

        return $driver;
    }
}
