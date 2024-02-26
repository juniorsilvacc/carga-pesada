<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdatePermission;
use App\Http\Resources\PermissionResource;
use App\Services\PermissionService;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    private $service;

    public function __construct(PermissionService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $name = $request->input('name');

        $permissions = $this->service->getPaginate($name);

        return PermissionResource::collection($permissions);
    }

    public function show($permissionId)
    {
        $permission = $this->service->getById($permissionId);

        if (!$permission) {
            return response()->json(['message' => 'Permissão não encontrada.'], 404);
        }

        return new PermissionResource($permission);
    }

    public function store(StoreUpdatePermission $request)
    {
        $data = $request->validated();

        $newpermission = $this->service->createPermission($data);

        return response()->json([
            'message' => 'Permissão criada com sucesso.',
            'permission' => new PermissionResource($newpermission),
        ], 201);
    }

    public function update(StoreUpdatePermission $request, $permissionId)
    {
        $permission = $this->service->updatePermission($request->validated(), $permissionId);

        return new PermissionResource($permission);
    }

    public function destroy($permissionId)
    {
        return $this->service->deletePermission($permissionId);
    }
}
