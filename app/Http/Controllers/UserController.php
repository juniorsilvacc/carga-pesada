<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateUser;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\Request;

/**
 * @OA\Schema(
 *     schema="User",
 *     required={"id", "nome", "email", "cpf", "rg", "data_nascimento", "password"},
 *
 *     @OA\Property(
 *         property="id",
 *         type="string",
 *         format="uuid",
 *         description="ID único do usuário (UUID)"
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
 */

/**
 * @OA\Schema(
 *     schema="StoreUpdateUser",
 *     title="StoreUpdateUser",
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
class UserController extends Controller
{
    private $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    /**
     * @OA\Get(
     *     path="/api/v1/users",
     *     summary="Listar todos os usuários",
     *     tags={"User"},
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
     *         description="Filtrar por CPF",
     *         required=false,
     *
     *         @OA\Schema(type="string")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Lista de usuários",
     *
     *         @OA\JsonContent(
     *             type="array",
     *
     *             @OA\Items(ref="#/components/schemas/User")
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $nome = $request->input('nome');
        $cpf = $request->input('cpf');

        $users = $this->service->getPaginate($nome, $cpf);

        return UserResource::collection($users);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/users/{id}",
     *     summary="Obter detalhes de um usuário específico",
     *     tags={"User"},
     *     security={
     *         {"bearerAuth": {}}
     *     },
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do usuário",
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
     *         description="Detalhes do usuário",
     *
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         description="Usuário não encontrado",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Usuário não encontrado."
     *             )
     *         )
     *     )
     * )
     */
    public function show($userId)
    {
        $user = $this->service->getById($userId);

        if (!$user) {
            return response()->json(['message' => 'Usuário não encontrado.'], 404);
        }

        return new UserResource($user);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/users",
     *     summary="Criar um novo usuário",
     *     tags={"User"},
     *     security={
     *         {"bearerAuth": {}}
     *     },
     *
     *     @OA\RequestBody(
     *         required=true,
     *         description="Dados do novo usuário",
     *
     *         @OA\JsonContent(ref="#/components/schemas/StoreUpdateUser")
     *     ),
     *
     *     @OA\Response(
     *         response=201,
     *         description="Usuário criado com sucesso",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="message", type="string", example="Usuário criado com sucesso."),
     *             @OA\Property(property="user", ref="#/components/schemas/User")
     *         )
     *     )
     * )
     */
    public function store(StoreUpdateUser $request)
    {
        $data = $request->validated();

        $newUser = $this->service->createUser($data);

        return response()->json([
            'message' => 'Usuário criado com sucesso.',
            'user' => new UserResource($newUser),
        ], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/v1/users/{id}",
     *     summary="Atualizar um usuário existente",
     *     tags={"User"},
     *     security={
     *         {"bearerAuth": {}}
     *     },
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do usuário a ser atualizado",
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
     *         description="Dados do usuário a ser atualizado",
     *
     *         @OA\JsonContent(ref="#/components/schemas/StoreUpdateUser")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Usuário atualizado com sucesso",
     *
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         description="Usuário não encontrado"
     *     )
     * )
     */
    public function update(StoreUpdateUser $request, $userId)
    {
        $user = $this->service->updateUser($request->validated(), $userId);

        return new UserResource($user);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/users/{id}",
     *     summary="Deletar um usuário existente",
     *     tags={"User"},
     *     security={
     *         {"bearerAuth": {}}
     *     },
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do usuário a ser deletado",
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
     *         description="Usuário deletado com sucesso"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Usuário não encontrado"
     *     )
     * )
     */
    public function destroy($userId)
    {
        return $this->service->deleteUser($userId);
    }
}
