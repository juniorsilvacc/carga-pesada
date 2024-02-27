<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateDriver;
use App\Http\Resources\DriverResource;
use App\Services\DriverService;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    private $service;

    public function __construct(DriverService $service)
    {
        $this->service = $service;
    }

    public function store(StoreUpdateDriver $request)
    {
        $data = $request->validated();

        $newDriver = $this->service->createDriver($data);

        return response()->json([
            'message' => 'Motorista criado com sucesso.',
            'drivers' => $newDriver,
        ], 201);
    }

    public function index(Request $request)
    {
        $nome = $request->input('nome');
        $cpf = $request->input('cpf');

        $driver = $this->service->getPaginate($nome, $cpf);

        return DriverResource::collection($driver);
    }

    public function show($driverId)
    {
        $driver = $this->service->getById($driverId);

        if (!$driver) {
            return response()->json(['message' => 'Motorista não encontrado.'], 404);
        }

        return new DriverResource($driver);
    }
}
