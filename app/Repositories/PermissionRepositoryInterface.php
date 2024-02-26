<?php

namespace App\Repositories;

interface PermissionRepositoryInterface
{
    public function getPaginate($name = null, $perPage = 5);

    public function createPermission(array $data);

    public function getById(string $permissionId);

    public function updatePermission(array $data, string $permissionId);

    public function deletePermission(string $permissionId);
}
