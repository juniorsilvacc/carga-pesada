<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateDriver;
use App\Services\DriverService;

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
}
