<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;

class PermissionUserController extends Controller
{
    private $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    /**
     * @OA\Post(
     *     path="/api/v1/users/{userId}/permissions/sync",
     *     summary="Sincronizar permissões de usuário",
     *     tags={"Permissions"},
     *     security={
     *         {"bearerAuth": {}}
     *     },
     *
     *     @OA\Parameter(
     *         name="userId",
     *         in="path",
     *         required=true,
     *         description="ID do usuário",
     *
     *         @OA\Schema(
     *             type="string",
     *             format="uuid"
     *         )
     *     ),
     *
     *     @OA\RequestBody(
     *         required=true,
     *         description="Lista de IDs de permissões para sincronizar",
     *
     *         @OA\JsonContent(
     *             type="object",
     *             required={"permissions"},
     *
     *             @OA\Property(
     *                 property="permissions",
     *                 type="array",
     *
     *                 @OA\Items(
     *                     type="string",
     *                     format="uuid",
     *                     description="ID da permissão"
     *                 )
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Permissões de usuário sincronizadas com sucesso",
     *
     *         @OA\JsonContent(
     *             type="object",
     *
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="ok"
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=404,
     *         description="Usuário não encontrado",
     *
     *         @OA\JsonContent(
     *             type="object",
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
    public function syncPermissionUser(string $userId, Request $request)
    {
        $response = $this->service->syncPermissions($userId, $request->permissions);

        if (!$response) {
            return response()->json(['message' => 'Usuário não encontrado.'], 404);
        }

        return response()->json(['message' => 'ok']);
    }
}
