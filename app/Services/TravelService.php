<?php

namespace App\Services;

use App\Repositories\TravelRepositoryInterface;

class TravelService
{
    private $repository;

    public function __construct(TravelRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getPaginate($motorista = null)
    {
        $travels = $this->repository->getPaginate($motorista);

        return $travels;
    }

    public function getById($travelId)
    {
        $travel = $this->repository->getById($travelId);

        return $travel;
    }

    public function createTravel(array $data)
    {
        $newTravel = $this->repository->createTravel($data);

        return $newTravel;
    }

    public function updateTravel(array $data, string $travelId)
    {
        $travel = $this->repository->updateTravel($data, $travelId);

        return $travel;
    }

    public function deleteTravel(string $travelId)
    {
        return $this->repository->deleteTravel($travelId);
    }
}
