<?php

namespace App\Services;

use App\Repositories\PermissionRepositoryInterface;

class PermissionService
{
    private $repository;

    public function __construct(PermissionRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getPaginate($nome = null)
    {
        $permissions = $this->repository->getPaginate($nome);

        return $permissions;
    }

    public function getById($permissionId)
    {
        $permission = $this->repository->getById($permissionId);

        return $permission;
    }

    public function createpermission(array $data)
    {
        $newpermission = $this->repository->createPermission($data);

        return $newpermission;
    }

    public function updatepermission(array $data, string $permissionId)
    {
        $permission = $this->repository->updatePermission($data, $permissionId);

        return $permission;
    }

    public function deletepermission(string $permissionId)
    {
        return $this->repository->deletePermission($permissionId);
    }
}
