<?php

namespace App\Repositories\Eloquent;

use App\Models\Truck;
use App\Repositories\TruckRepositoryInterface;

class TruckRepository implements TruckRepositoryInterface
{
    private $model;

    public function __construct(Truck $truck)
    {
        $this->model = $truck;
    }

    public function getPaginate($placa = null, $perPage = 5)
    {
        $query = $this->model->orderBy('created_at', 'asc');

        if ($placa !== null) {
            $query->where('placa', 'LIKE', "%{$placa}%");
        }

        $trucks = $query->paginate($perPage);

        return $trucks;
    }

    public function createTruck(array $data)
    {
        $newTruck = $this->model->create($data);

        return $newTruck;
    }

    public function getById(string $truckId)
    {
        $truck = $this->model->where('id', $truckId)->first();

        return $truck;
    }

    public function updateTruck(array $data, string $truckId)
    {
        $truck = $this->model->findOrFail($truckId);

        $truck->update($data);

        return $truck;
    }

    public function deleteTruck(string $truckId)
    {
        $truck = $this->model->where('id', $truckId)->first();

        if (!$truck) {
            return response()->json(['message' => 'Caminhão não encontrado.'], 404);
        }

        $truck->delete();
    }
}
