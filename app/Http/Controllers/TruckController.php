<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateTruck;
use App\Http\Resources\TruckResource;
use App\Services\TruckService;
use Illuminate\Http\Request;

/**
 * @OA\Schema(
 *     schema="Truck",
 *     required={"id", "placa", "renavan", "antt", "modalidade"},
 *
 *     @OA\Property(
 *         property="id",
 *         type="string",
 *         format="uuid",
 *         description="ID único do caminhão (UUID)"
 *     ),
 *     @OA\Property(
 *         property="placa",
 *         type="string",
 *         description="Placa"
 *     ),
 *     @OA\Property(
 *         property="renavan",
 *         type="string",
 *         description="Renavan"
 *     ),
 *     @OA\Property(
 *         property="antt",
 *         type="string",
 *         description="Antt"
 *     ),
 *     @OA\Property(
 *         property="modalidade",
 *         type="string",
 *         description="Modalidade"
 *     ),
 * )
 *
 * @OA\Schema(
 *     schema="StoreUpdateTruck",
 *     title="StoreUpdateTruck",
 *     required={"placa", "renavan", "antt", "modalidade"},
 *
 *     @OA\Property(
 *         property="placa",
 *         type="string",
 *         description="Placa"
 *     ),
 *     @OA\Property(
 *         property="renavan",
 *         type="string",
 *         description="Renavan"
 *     ),
 *     @OA\Property(
 *         property="antt",
 *         type="string",
 *         description="Antt"
 *     ),
 *     @OA\Property(
 *         property="modalidade",
 *         type="string",
 *         description="Modalidade"
 *     ),
 * )
 */
class TruckController extends Controller
{
    private $service;

    public function __construct(TruckService $service)
    {
        $this->service = $service;
    }

    /**
     * @OA\Get(
     *     path="/api/v1/trucks",
     *     summary="Listar todos os caminhões",
     *     tags={"Truck"},
     *     security={
     *         {"bearerAuth": {}}
     *     },
     *
     *     @OA\Parameter(
     *         name="placa",
     *         in="query",
     *         description="Filtrar por placa",
     *         required=false,
     *
     *         @OA\Schema(type="string")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Lista de caminhões",
     *
     *         @OA\JsonContent(
     *             type="array",
     *
     *             @OA\Items(ref="#/components/schemas/Truck")
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $placa = $request->input('placa');

        $trucks = $this->service->getPaginate($placa);

        return TruckResource::collection($trucks);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/trucks/{id}",
     *     summary="Obter detalhes de um caminhão específico",
     *     tags={"Truck"},
     *     security={
     *         {"bearerAuth": {}}
     *     },
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do caminhão",
     *         required=true,
     *
     *         @OA\Schema(
     *             type="string",
     *             format="uuid"
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Detalhes do caminhão",
     *
     *         @OA\JsonContent(ref="#/components/schemas/Truck")
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         description="Caminhão não encontrado",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Caminhão não encontrado."
     *             )
     *         )
     *     )
     * )
     */
    public function show($truckId)
    {
        $truck = $this->service->getById($truckId);

        if (!$truck) {
            return response()->json(['message' => 'Caminhão não encontrado.'], 404);
        }

        return new TruckResource($truck);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/trucks",
     *     summary="Criar um novo caminhão",
     *     tags={"Truck"},
     *     security={
     *         {"bearerAuth": {}}
     *     },
     *
     *     @OA\RequestBody(
     *         required=true,
     *         description="Dados do novo caminhão",
     *
     *         @OA\JsonContent(ref="#/components/schemas/StoreUpdateTruck")
     *     ),
     *
     *     @OA\Response(
     *         response=201,
     *         description="Caminhão criado com sucesso",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="message", type="string", example="Caminhão criado com sucesso."),
     *             @OA\Property(property="truck", ref="#/components/schemas/Truck")
     *         )
     *     )
     * )
     */
    public function store(StoreUpdateTruck $request)
    {
        $data = $request->validated();

        $newTruck = $this->service->createTruck($data);

        return response()->json([
            'message' => 'Caminhão criado com sucesso.',
            'truck' => new TruckResource($newTruck),
        ], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/v1/trucks/{id}",
     *     summary="Atualizar um caminhão existente",
     *     tags={"Truck"},
     *     security={
     *         {"bearerAuth": {}}
     *     },
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do caminhão a ser atualizado",
     *         required=true,
     *
     *         @OA\Schema(
     *             type="string",
     *             format="uuid"
     *         )
     *     ),
     *
     *     @OA\RequestBody(
     *         required=true,
     *         description="Dados do caminhão a ser atualizado",
     *
     *         @OA\JsonContent(ref="#/components/schemas/StoreUpdateTruck")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Caminhão atualizado com sucesso",
     *
     *         @OA\JsonContent(ref="#/components/schemas/Truck")
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         description="Caminhão não encontrado"
     *     )
     * )
     */
    public function update(StoreUpdateTruck $request, $truckId)
    {
        $truck = $this->service->updateTruck($request->validated(), $truckId);

        return new TruckResource($truck);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/trucks/{id}",
     *     summary="Deletar um caminhão existente",
     *     tags={"Truck"},
     *     security={
     *         {"bearerAuth": {}}
     *     },
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do caminhão a ser deletado",
     *         required=true,
     *
     *         @OA\Schema(
     *             type="string",
     *             format="uuid"
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Caminhão deletado com sucesso"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Caminhão não encontrado"
     *     )
     * )
     */
    public function destroy($truckId)
    {
        return $this->service->deleteTruck($truckId);
    }
}
