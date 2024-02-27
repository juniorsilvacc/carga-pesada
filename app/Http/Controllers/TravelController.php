<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateTravel;
use App\Http\Resources\TravelResource;
use App\Services\TravelService;
use Illuminate\Http\Request;

class TravelController extends Controller
{
    private $service;

    public function __construct(TravelService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $motorista = $request->input('motorista');

        $travels = $this->service->getPaginate($motorista);

        return TravelResource::collection($travels);
    }

    public function show($travelId)
    {
        $travel = $this->service->getById($travelId);

        if (!$travel) {
            return response()->json(['message' => 'Viagem não encontrada.'], 404);
        }

        return new TravelResource($travel);
    }

    public function store(StoreUpdateTravel $request)
    {
        $data = $request->validated();

        $newTravel = $this->service->createTravel($data);

        return response()->json([
            'message' => 'Viagem criada com sucesso.',
            'travel' => new TravelResource($newTravel),
        ], 201);
    }

    public function update(StoreUpdateTravel $request, $travelId)
    {
        $travel = $this->service->updateTravel($request->validated(), $travelId);

        return new TravelResource($travel);
    }

    public function destroy($travelId)
    {
        return $this->service->deleteTravel($travelId);
    }
}
