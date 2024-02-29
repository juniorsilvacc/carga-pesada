<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateDriver;
use App\Http\Resources\DriverResource;
use App\Services\DriverService;
use Illuminate\Http\Request;

/**
 * @OA\Schema(
 *     schema="Driver",
 *     required={"id", "nome", "email", "cpf", "rg", "data_nascimento", "password"},
 *
 *     @OA\Property(
 *         property="id",
 *         type="string",
 *         format="uuid",
 *         description="ID único do motorista (UUID)"
 *     ),
 *     @OA\Property(
 *         property="nome",
 *         type="string",
 *         description="Nome"
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         description="Email"
 *     ),
 *     @OA\Property(
 *         property="cpf",
 *         type="string",
 *         description="CPF"
 *     ),
 *     @OA\Property(
 *         property="rg",
 *         type="string",
 *         description="RG"
 *     ),
 *     @OA\Property(
 *         property="data_nascimento",
 *         type="string",
 *         format="date",
 *         description="Data de Nascimento"
 *     ),
 *     @OA\Property(
 *         property="password",
 *         type="string",
 *         description="Password"
 *     ),
 * )
 *
 * @OA\Schema(
 *     schema="StoreUpdateDriver",
 *     title="StoreUpdateDriver",
 *     required={"nome", "email", "cpf", "rg", "data_nascimento", "password"},
 *
 *     @OA\Property(
 *         property="nome",
 *         type="string",
 *         description="Nome"
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         description="Email"
 *     ),
 *     @OA\Property(
 *         property="cpf",
 *         type="string",
 *         description="CPF"
 *     ),
 *     @OA\Property(
 *         property="rg",
 *         type="string",
 *         description="RG"
 *     ),
 *     @OA\Property(
 *         property="data_nascimento",
 *         type="string",
 *         format="date",
 *         description="Data de Nascimento"
 *     ),
 *     @OA\Property(
 *         property="password",
 *         type="string",
 *         description="Password"
 *     ),
 * )
 */
class DriverController extends Controller
{
    private $service;

    public function __construct(DriverService $service)
    {
        $this->service = $service;
    }

    /**
     * @OA\SecurityScheme(
     *     type="apiKey",
     *     in="header",
     *     securityScheme="bearerAuth",
     *     name="Authorization"
     * )
     */
    /**
     * @OA\Post(
     *     path="/api/v1/drivers",
     *     summary="Criar um novo motorista",
     *     tags={"Driver"},
     *     security={
     *         {"bearerAuth": {}}
     *     },
     *
     *     @OA\RequestBody(
     *         required=true,
     *         description="Dados do novo motorista",
     *
     *         @OA\JsonContent(ref="#/components/schemas/StoreUpdateDriver")
     *     ),
     *
     *     @OA\Response(
     *         response=201,
     *         description="Motorista criado com sucesso",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="message", type="string", example="Motorista criado com sucesso."),
     *             @OA\Property(property="driver", ref="#/components/schemas/Driver")
     *         )
     *     )
     * )
     */
    public function store(StoreUpdateDriver $request)
    {
        $data = $request->validated();

        $newDriver = $this->service->createDriver($data);

        return response()->json([
            'message' => 'Motorista criado com sucesso.',
            'driver' => new DriverResource($newDriver),
        ], 201);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/drivers",
     *     summary="Listar todos os motoristas",
     *     tags={"Driver"},
     *     security={
     *         {"bearerAuth": {}}
     *     },
     *
     *     @OA\Parameter(
     *         name="nome",
     *         in="query",
     *         description="Filtrar por nome",
     *         required=false,
     *
     *         @OA\Schema(type="string")
     *     ),
     *
     *     @OA\Parameter(
     *         name="cpf",
     *         in="query",
     *         description="Filtrar por cpf",
     *         required=false,
     *
     *         @OA\Schema(type="string")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Lista de motoristas",
     *
     *         @OA\JsonContent(
     *             type="array",
     *
     *             @OA\Items(ref="#/components/schemas/Driver")
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $nome = $request->input('nome');
        $cpf = $request->input('cpf');

        $driver = $this->service->getPaginate($nome, $cpf);

        return DriverResource::collection($driver);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/drivers/{id}",
     *     summary="Obter detalhes de um motorista específico",
     *     tags={"Driver"},
     *     security={
     *         {"bearerAuth": {}}
     *     },
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do motorista",
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
     *         description="Detalhes do motorista",
     *
     *         @OA\JsonContent(ref="#/components/schemas/Driver")
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         description="Motorista não encontrado",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Motorista não encontrado."
     *             )
     *         )
     *     )
     * )
     */
    public function show($driverId)
    {
        $driver = $this->service->getById($driverId);

        if (!$driver) {
            return response()->json(['message' => 'Motorista não encontrado.'], 404);
        }

        return new DriverResource($driver);
    }
}
