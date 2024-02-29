<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdatePermission;
use App\Http\Resources\PermissionResource;
use App\Services\PermissionService;
use Illuminate\Http\Request;

/**
 * @OA\Schema(
 *     schema="Permission",
 *     required={"id", "nome", "descricao"},
 *
 *     @OA\Property(
 *         property="id",
 *         type="string",
 *         format="uuid",
 *         description="ID único da permissão (UUID)"
 *     ),
 *     @OA\Property(
 *         property="nome",
 *         type="string",
 *         description="Nome"
 *     ),
 *     @OA\Property(
 *         property="descricao",
 *         type="string",
 *         description="Descrição",
 *         nullable=true
 *     )
 * )
 */
/**
 * @OA\Schema(
 *     schema="StoreUpdatePermission",
 *     title="StoreUpdatePermission",
 *     required={"nome", "descricao"},
 *
 *     @OA\Property(
 *         property="nome",
 *         type="string",
 *         description="Nome"
 *     ),
 *     @OA\Property(
 *         property="descricao",
 *         type="string",
 *         description="Descrição",
 *         nullable=true
 *     )
 * )
 */
class PermissionController extends Controller
{
    private $service;

    public function __construct(PermissionService $service)
    {
        $this->service = $service;
    }

    /**
     * @OA\Get(
     *     path="/api/v1/permissions",
     *     summary="Listar todas as permissões",
     *     tags={"Permission"},
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
     *     @OA\Response(
     *         response=200,
     *         description="Lista de permissões",
     *
     *         @OA\JsonContent(
     *             type="array",
     *
     *             @OA\Items(ref="#/components/schemas/Permission")
     *         )
     *     )
     * )
     */
    public function index(Request $request)
    {
        $nome = $request->input('nome');

        $permissions = $this->service->getPaginate($nome);

        return PermissionResource::collection($permissions);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/permissions/{id}",
     *     summary="Obter detalhes de uma permissão específica",
     *     tags={"Permission"},
     *     security={
     *         {"bearerAuth": {}}
     *     },
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID da permissão",
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
     *         description="Detalhes da permissão",
     *
     *         @OA\JsonContent(ref="#/components/schemas/Permission")
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         description="Permissão não encontrada",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Permissão não encontrada."
     *             )
     *         )
     *     )
     * )
     */
    public function show($permissionId)
    {
        $permission = $this->service->getById($permissionId);

        if (!$permission) {
            return response()->json(['message' => 'Permissão não encontrada.'], 404);
        }

        return new PermissionResource($permission);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/permissions",
     *     summary="Criar uma nova permissão",
     *     tags={"Permission"},
     *     security={
     *         {"bearerAuth": {}}
     *     },
     *
     *     @OA\RequestBody(
     *         required=true,
     *         description="Dados da nova permissão",
     *
     *         @OA\JsonContent(ref="#/components/schemas/StoreUpdatePermission")
     *     ),
     *
     *     @OA\Response(
     *         response=201,
     *         description="Permissão criada com sucesso",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="message", type="string", example="Permissão criada com sucesso."),
     *             @OA\Property(property="permission", ref="#/components/schemas/Permission")
     *         )
     *     )
     * )
     */
    public function store(StoreUpdatePermission $request)
    {
        $data = $request->validated();

        $newpermission = $this->service->createPermission($data);

        return response()->json([
            'message' => 'Permissão criada com sucesso.',
            'permission' => new PermissionResource($newpermission),
        ], 201);
    }

    /**
     * @OA\Put(
     *     path="/api/v1/permissions/{id}",
     *     summary="Atualizar uma permissão existente",
     *     tags={"Permission"},
     *     security={
     *         {"bearerAuth": {}}
     *     },
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID da permissão a ser atualizada",
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
     *         description="Dados da permissão a ser atualizada",
     *
     *         @OA\JsonContent(ref="#/components/schemas/StoreUpdatePermission")
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Permissão atualizada com sucesso",
     *
     *         @OA\JsonContent(ref="#/components/schemas/Permission")
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         description="Permissão não encontrada"
     *     )
     * )
     */
    public function update(StoreUpdatePermission $request, $permissionId)
    {
        $permission = $this->service->updatePermission($request->validated(), $permissionId);

        return new PermissionResource($permission);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/permissions/{id}",
     *     summary="Deletar uma permissão existente",
     *     tags={"Permission"},
     *     security={
     *         {"bearerAuth": {}}
     *     },
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID da permissão a ser deletada",
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
     *         description="Permissão deletada com sucesso"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Permissão não encontrada"
     *     )
     * )
     */
    public function destroy($permissionId)
    {
        return $this->service->deletePermission($permissionId);
    }
}
