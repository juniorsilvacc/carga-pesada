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

    public function syncPermissionUser(string $userId, Request $request)
    {
        $response = $this->service->syncPermissions($userId, $request->permissions);

        if (!$response) {
            return response()->json(['message' => 'Usuário não encontrado.'], 404);
        }

        return response()->json(['message' => 'ok']);
    }
}
