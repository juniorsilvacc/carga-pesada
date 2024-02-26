<?php

namespace App\Repositories\Eloquent;

use App\Models\Permission;
use App\Repositories\PermissionRepositoryInterface;

class PermissionRepository implements PermissionRepositoryInterface
{
    private $model;

    public function __construct(Permission $permission)
    {
        $this->model = $permission;
    }

    public function getPaginate($name = null, $perPage = 5)
    {
        $query = $this->model->orderBy('created_at', 'asc');

        if ($name !== null) {
            $query->where('name', 'LIKE', "%{$name}%");
        }

        $permissions = $query->paginate($perPage);

        return $permissions;
    }

    public function createPermission(array $data)
    {
        $newPermission = $this->model->create($data);

        return $newPermission;
    }

    public function getById(string $permissionId)
    {
        $permission = $this->model->where('id', $permissionId)->first();

        return $permission;
    }

    public function updatePermission(array $data, string $permissionId)
    {
        $permission = $this->model->findOrFail($permissionId);

        $permission->update($data);

        return $permission;
    }

    public function deletePermission(string $permissionId)
    {
        $permission = $this->model->where('id', $permissionId)->first();

        if (!$permission) {
            return response()->json(['message' => 'Permissão não encontrada.'], 404);
        }

        $permission->delete();
    }
}
