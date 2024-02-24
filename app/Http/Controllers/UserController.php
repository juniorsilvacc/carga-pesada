<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateUser;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $name = $request->input('name');

        $users = $this->service->getPaginate($name);

        return UserResource::collection($users);
    }

    public function show()
    {
    }

    public function store(StoreUpdateUser $request)
    {
        $data = $request->validated();

        $newUser = $this->service->createUser($data);

        return response()->json([
            'message' => 'Usuário criado com sucesso.',
            'user' => new UserResource($newUser),
        ], 201);
    }

    public function update(Request $request)
    {
    }

    public function destroy()
    {
    }
}
