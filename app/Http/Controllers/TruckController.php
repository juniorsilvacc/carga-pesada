<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateTruck;
use App\Http\Resources\TruckResource;
use App\Services\TruckService;
use Illuminate\Http\Request;

class TruckController extends Controller
{
    private $service;

    public function __construct(TruckService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $placa = $request->input('placa');

        $trucks = $this->service->getPaginate($placa);

        return TruckResource::collection($trucks);
    }

    public function show($truckId)
    {
        $truck = $this->service->getById($truckId);

        if (!$truck) {
            return response()->json(['message' => 'Caminhão não encontrado.'], 404);
        }

        return new TruckResource($truck);
    }

    public function store(StoreUpdateTruck $request)
    {
        $data = $request->validated();

        $newTruck = $this->service->createTruck($data);

        return response()->json([
            'message' => 'Caminhão criado com sucesso.',
            'truck' => new TruckResource($newTruck),
        ], 201);
    }

    public function update(StoreUpdateTruck $request, $truckId)
    {
        $truck = $this->service->updateTruck($request->validated(), $truckId);

        return new TruckResource($truck);
    }

    public function destroy($truckId)
    {
        return $this->service->deleteTruck($truckId);
    }
}
