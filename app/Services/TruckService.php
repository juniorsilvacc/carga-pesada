<?php

namespace App\Services;

use App\Repositories\TruckRepositoryInterface;

class TruckService
{
    private $repository;

    public function __construct(TruckRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getPaginate($placa = null)
    {
        $trucks = $this->repository->getPaginate($placa);

        return $trucks;
    }

    public function getById($truckId)
    {
        $truck = $this->repository->getById($truckId);

        return $truck;
    }

    public function createTruck(array $data)
    {
        $newTruck = $this->repository->createTruck($data);

        return $newTruck;
    }

    public function updateTruck(array $data, string $truckId)
    {
        $truck = $this->repository->updateTruck($data, $truckId);

        return $truck;
    }

    public function deleteTruck(string $truckId)
    {
        return $this->repository->deleteTruck($truckId);
    }
}
