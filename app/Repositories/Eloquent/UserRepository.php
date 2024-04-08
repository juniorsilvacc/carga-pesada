<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    private $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function getPaginate($nome = null, $cpf = null, $perPage = 5)
    {
        $query = $this->model->with('permissions')->orderBy('created_at', 'asc');

        if ($nome !== null) {
            $query->where('nome', 'LIKE', "%{$nome}%");
        }

        if ($cpf !== null) {
            $query->where('cpf', 'LIKE', "%{$cpf}%");
        }

        $users = $query->paginate($perPage);

        return $users;
    }

    public function createUser(array $data)
    {
        $newUser = $this->model->create($data);

        return $newUser;
    }

    public function getById(string $userId)
    {
        $user = $this->model->with('permissions')->where('id', $userId)->first();

        return $user;
    }

    public function updateUser(array $data, string $userId)
    {
        $user = $this->model->findOrFail($userId);

        $user->update($data);

        return $user;
    }

    public function deleteUser(string $userId)
    {
        $user = $this->model->where('id', $userId)->first();

        if (!$user) {
            return response()->json(['message' => 'Usuário não encontrado.'], 404);
        }

        $user->delete();
    }

    public function findByCpf(string $cpf)
    {
        $user = $this->model->where('cpf', $cpf)->first();

        return $user;
    }

    public function syncPermissions(string $userId, array $permissions): ?bool
    {
        $user = $this->model->where('id', $userId)->first();

        if (!$user) {
            return null;
        }

        $user->permissions()->sync($permissions);

        return true;
    }

    public function hasPermission(User $user, string $permissionName): bool
    {
        if ($user->isSuperAdmin() && $user->superuser == 1) {
            return true;
        }

        return $user->permissions()->where('nome', $permissionName)->exists();
    }
}
