<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateTravel;
use App\Http\Resources\TravelResource;
use App\Services\TravelService;
use Illuminate\Http\Request;

/**
 * @OA\Schema(
 *     schema="Travel",
 *     required={"id", "cidade_saida", "estado_saida", "estado_destino", "cidade_destino",
 *     "peso_carga", "motorista_id", "caminhao_id", "data_viagem"},
 *
 *     @OA\Property(
 *         property="id",
 *         type="string",
 *         format="uuid",
 *         description="ID único da viagem (UUID)"
 *     ),
 *     @OA\Property(
 *         property="cidade_saida",
 *         type="string",
 *         description="Cidade Saída"
 *     ),
 *     @OA\Property(
 *         property="estado_saida",
 *         type="string",
 *         description="Estado Saída"
 *     ),
 *     @OA\Property(
 *         property="cidade_destino",
 *         type="string",
 *         description="Cidade Destino"
 *     ),
 *     @OA\Property(
 *         property="estado_destino",
 *         type="string",
 *         description="Estado Destino"
 *     ),
 *     @OA\Property(
 *         property="peso_carga",
 *         type="string",
 *         description="Peso Carga"
 *     ),
 *     @OA\Property(
 *         property="data_viagem",
 *         type="string",
 *         format="date",
 *         description="Peso Carga"
 *     ),
 *     @OA\Property(
 *         property="caminhao_id",
 *         type="string",
 *         format="uuid",
 *         description="ID único do caminhão (UUID)"
 *     ),
 *     @OA\Property(
 *         property="motorista_id",
 *         type="string",
 *         format="uuid",
 *         description="ID único do motorista (UUID)"
 *     ),
 * )
 *
 * @OA\Schema(
 *     schema="StoreUpdateTravel",
 *     title="StoreUpdateTravel",
 *     required={"id", "cidade_saida", "estado_saida", "estado_destino", "cidade_destino",
 *     "peso_carga", "motorista_id", "caminhao_id", "data_viagem"},
 *
 *     @OA\Property(
 *         property="cidade_saida",
 *         type="string",
 *         description="Cidade Saída"
 *     ),
 *     @OA\Property(
 *         property="estado_saida",
 *         type="string",
 *         description="Estado Saída"
 *     ),
 *     @OA\Property(
 *         property="cidade_destino",
 *         type="string",
 *         description="Cidade Destino"
 *     ),
 *     @OA\Property(
 *         property="estado_destino",
 *         type="string",
 *         description="Estado Destino"
 *     ),
 *     @OA\Property(
 *         property="peso_carga",
 *         type="string",
 *         description="Peso Carga"
 *     ),
 *     @OA\Property(
 *         property="data_viagem",
 *         type="string",
 *         format="date",
 *         description="Peso Carga"
 *     ),
 *     @OA\Property(
 *         property="caminhao_id",
 *         type="string",
 *         format="uuid",
 *         description="ID único do caminhão (UUID)"
 *     ),
 *     @OA\Property(
 *         property="motorista_id",
 *         type="string",
 *         format="uuid",
 *         description="ID único do motorista (UUID)"
 *     ),
 * )
 */
class TravelController extends Controller
{
    private $service;

    public function __construct(TravelService $service)
    {
        $this->service = $service;
    }

    /**
     * @OA\Get(
     *     path="/api/v1/travels",
     *     summary="Listar todas as viagens",
     *     tags={"Travel"},
     *     security={
     *         {"bearerAuth": {}}
     *     },
     *
     *     @OA\Parameter(
     *         name="motorista",
     *         in="query",
     *         description="Filtrar por Motorista",
     *         required=false,
     *
     *         @OA\Schema(type="string")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Lista de viagens",
     *
     *         @OA\JsonContent(
     *             type="array",
     *
     *             @OA\Items(ref="#/components/schemas/Travel")
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $motorista = $request->input('motorista');

        $travels = $this->service->getPaginate($motorista);

        return TravelResource::collection($travels);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/travels/{id}",
     *     summary="Obter detalhes de uma viagem específica",
     *     tags={"Travel"},
     *     security={
     *         {"bearerAuth": {}}
     *     },
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID da viagem",
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
     *         description="Detalhes da viagem",
     *
     *         @OA\JsonContent(ref="#/components/schemas/Travel")
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         description="Viagem não encontrada",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Viagem não encontrada."
     *             )
     *         )
     *     )
     * )
     */
    public function show($travelId)
    {
        $travel = $this->service->getById($travelId);

        if (!$travel) {
            return response()->json(['message' => 'Viagem não encontrada.'], 404);
        }

        return new TravelResource($travel);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/travels",
     *     summary="Criar uma nova viagem",
     *     tags={"Travel"},
     *     security={
     *         {"bearerAuth": {}}
     *     },
     *
     *     @OA\RequestBody(
     *         required=true,
     *         description="Dados da nova viagem",
     *
     *         @OA\JsonContent(ref="#/components/schemas/StoreUpdateTravel")
     *     ),
     *
     *     @OA\Response(
     *         response=201,
     *         description="Viagem criada com sucesso",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="message", type="string", example="Viagem criada com sucesso."),
     *             @OA\Property(property="travel", ref="#/components/schemas/Travel")
     *         )
     *     )
     * )
     */
    public function store(StoreUpdateTravel $request)
    {
        $data = $request->validated();

        $newTravel = $this->service->createTravel($data);

        return response()->json([
            'message' => 'Viagem criada com sucesso.',
            'travel' => new TravelResource($newTravel),
        ], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/v1/travels/{id}",
     *     summary="Atualizar uma viagem existente",
     *     tags={"Travel"},
     *     security={
     *         {"bearerAuth": {}}
     *     },
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID da viagem a ser atualizada",
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
     *         description="Dados da viagem a ser atualizada",
     *
     *         @OA\JsonContent(ref="#/components/schemas/StoreUpdateTravel")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Viagem atualizada com sucesso",
     *
     *         @OA\JsonContent(ref="#/components/schemas/Travel")
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         description="Viagem não encontrada"
     *     )
     * )
     */
    public function update(StoreUpdateTravel $request, $travelId)
    {
        $travel = $this->service->updateTravel($request->validated(), $travelId);

        return new TravelResource($travel);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/travels/{id}",
     *     summary="Deletar uma viagem existente",
     *     tags={"Travel"},
     *     security={
     *         {"bearerAuth": {}}
     *     },
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID da viagem a ser deletada",
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
     *         description="Viagem deletada com sucesso"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Viagem não encontrada"
     *     )
     * )
     */
    public function destroy($travelId)
    {
        return $this->service->deleteTravel($travelId);
    }
}
