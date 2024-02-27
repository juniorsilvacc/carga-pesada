<?php

namespace App\Repositories;

interface TravelRepositoryInterface
{
    public function getPaginate($motorista = null, $perPage = 5);

    public function createTravel(array $data);

    public function getById(string $travelId);

    public function updateTravel(array $data, string $travelId);

    public function deleteTravel(string $travelId);
}
