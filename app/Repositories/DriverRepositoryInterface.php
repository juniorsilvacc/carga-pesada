<?php

namespace App\Repositories;

interface DriverRepositoryInterface
{
    public function createDriver(array $data);

    public function getPaginate($nome = null, $cpf = null, $perPage = 5);

    public function getById(string $driverId);
}
