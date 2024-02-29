<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Http\Resources\UserResource;
use App\Repositories\Eloquent\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

/**
 * @OA\Schema(
 *     schema="Autenticated",
 *     required={"id", "cpf", "password", "device_name"},
 *
 *     @OA\Property(
 *         property="id",
 *         type="string",
 *         format="uuid",
 *         description="ID único do contato (UUID)"
 *     ),
 *     @OA\Property(
 *         property="cpf",
 *         type="string",
 *         description="CPF"
 *     ),
 *     @OA\Property(
 *         property="password",
 *         type="string",
 *         description="Password"
 *     ),
 *     @OA\Property(
 *         property="device_name",
 *         type="string",
 *         description="device_name"
 *     ),
 * )
 *
 * @OA\Schema(
 *     schema="User",
 *     title="User",
 *     required={"id", "nome", "email", "cpf", "rg", "data_nascimento", "ativo", "superUser", "permissions"},
 *
 *     @OA\Property(
 *         property="id",
 *         type="string",
 *         format="uuid",
 *         description="ID único do usuário"
 *     ),
 *     @OA\Property(
 *         property="nome",
 *         type="string",
 *         description="Nome completo do usuário"
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         format="email",
 *         description="Endereço de e-mail do usuário"
 *     ),
 *     @OA\Property(
 *         property="cpf",
 *         type="string",
 *         description="Número do CPF do usuário"
 *     ),
 *     @OA\Property(
 *         property="rg",
 *         type="string",
 *         description="Número do RG do usuário"
 *     ),
 *     @OA\Property(
 *         property="data_nascimento",
 *         type="string",
 *         format="date",
 *         description="Data de nascimento do usuário (no formato YYYY-MM-DD)"
 *     ),
 *     @OA\Property(
 *         property="ativo",
 *         type="boolean",
 *         description="Indica se o usuário está ativo ou não"
 *     ),
 *     @OA\Property(
 *         property="superUser",
 *         type="boolean",
 *         description="Indica se o usuário possui privilégios de super usuário"
 *     ),
 *     @OA\Property(
 *         property="permissions",
 *         type="array",
 *         description="Lista de permissões do usuário",
 *
 *         @OA\Items(ref="#/components/schemas/Permission")
 *     )
 * )
 *
 * @OA\Schema(
 *     schema="Permission",
 *     title="Permission",
 *     required={"id", "nome", "descricao"},
 *
 *     @OA\Property(
 *         property="id",
 *         type="string",
 *         format="uuid",
 *         description="ID único da permissão"
 *     ),
 *     @OA\Property(
 *         property="nome",
 *         type="string",
 *         description="Nome da permissão"
 *     ),
 *     @OA\Property(
 *         property="descricao",
 *         type="string",
 *         description="Descrição da permissão"
 *     )
 * )
 */
class AuthController extends Controller
{
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @OA\Post(
     *     path="/api/v1/login/access-token",
     *     summary="Login",
     *     tags={"Authentication"},
     *
     *     @OA\RequestBody(
     *         required=true,
     *         description="Dados de autenticação",
     *
     *         @OA\JsonContent(
     *             required={"cpf", "password", "device_name"},
     *
     *             @OA\Property(property="cpf", type="string", example="12345678900"),
     *             @OA\Property(property="password", type="string", example="password"),
     *             @OA\Property(property="device_name", type="string", example="auth")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="Usuário autenticado com sucesso",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="access_token", type="string", example="token"),
     *             @OA\Property(property="user", ref="#/components/schemas/Autenticated")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=401,
     *         description="Credenciais inválidas",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(property="message", type="string", example="The provided credentials are incorrect.")
     *         )
     *     )
     * )
     */
    public function login(AuthRequest $request)
    {
        $user = $this->repository->findByCpf($request->cpf);

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages(['cpf' => ['The provided credentials are incorrect.']]);
        }

        $token = $user->createToken($request->device_name)->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'user' => new UserResource($user),
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/login/check-token",
     *     summary="Verifica se o token de acesso é válido",
     *     tags={"Authentication"},
     *     security={
     *         {"bearerAuth": {}}
     *     },
     *
     *     @OA\Response(
     *         response=200,
     *         description="Usuário autenticado",
     *
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     *
     *     @OA\Response(
     *         response=401,
     *         description="Token inválido ou expirado"
     *     )
     * )
     */
    public function checkToken()
    {
        $user = Auth::user();

        if ($user) {
            $user->load('permissions');

            return response()->json([
                'user' => new UserResource($user),
            ]);
        } else {
            return response()->json([
                'message' => 'Token inválido ou expirado.',
            ], 401);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/v1/login/logout",
     *     summary="Deslogar o usuário",
     *     tags={"Authentication"},
     *     security={
     *         {"bearerAuth": {}}
     *     },
     *
     *     @OA\Response(
     *         response=200,
     *         description="Logout bem-sucedido",
     *
     *         @OA\JsonContent(
     *
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Logout bem-sucedido."
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=401,
     *         description="Não autorizado"
     *     )
     * )
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logout bem-sucedido.']);
    }
}
