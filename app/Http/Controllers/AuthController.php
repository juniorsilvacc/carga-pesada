<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Http\Resources\UserResource;
use App\Repositories\Eloquent\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

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

    public function checkToken()
    {
        $user = Auth::user();

        if ($user) {
            return response()->json([
                'user' => $user,
            ]);
        } else {
            return response()->json([
                'message' => 'Token inválido ou expirado.',
            ], 401);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logout bem-sucedido.']);
    }
}
