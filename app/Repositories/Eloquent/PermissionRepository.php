<?php

namespace App\Repositories\Eloquent;

use App\Models\Permission;
use App\Models\User;
use App\Repositories\PermissionRepositoryInterface;

class PermissionRepository implements PermissionRepositoryInterface
{
    private $model;

    public function __construct(Permission $permission)
    {
        $this->model = $permission;
    }
}
