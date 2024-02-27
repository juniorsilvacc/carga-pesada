<?php

namespace App\Repositories\Eloquent;

use App\Models\Travel;
use App\Repositories\TravelRepositoryInterface;

class TravelRepository implements TravelRepositoryInterface
{
    private $model;

    public function __construct(Travel $travel)
    {
        $this->model = $travel;
    }

    public function getPaginate($motorista = null, $perPage = 5)
    {
        $query = $this->model->orderBy('created_at', 'asc');

        if ($motorista !== null) {
            $query->where('motorista', 'LIKE', "%{$motorista}%");
        }

        $travels = $query->paginate($perPage);

        return $travels;
    }

    public function createTravel(array $data)
    {
        $newTravel = $this->model->create($data);

        return $newTravel;
    }

    public function getById(string $travelId)
    {
        $travel = $this->model->where('id', $travelId)->first();

        return $travel;
    }

    public function updateTravel(array $data, string $travelId)
    {
        $travel = $this->model->findOrFail($travelId);

        $travel->update($data);

        return $travel;
    }

    public function deleteTravel(string $travelId)
    {
        $travel = $this->model->where('id', $travelId)->first();

        if (!$travel) {
            return response()->json(['message' => 'Viagem não encontrada.'], 404);
        }

        $travel->delete();
    }
}
