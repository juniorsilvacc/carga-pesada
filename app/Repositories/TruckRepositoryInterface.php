<?php

namespace App\Repositories;

interface TruckRepositoryInterface
{
    public function getPaginate($placa = null, $perPage = 5);

    public function createTruck(array $data);

    public function getById(string $truckId);

    public function updateTruck(array $data, string $truckId);

    public function deleteTruck(string $truckId);
}
