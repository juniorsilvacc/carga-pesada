<?php

namespace App\Repositories\Eloquent;

use App\Models\Driver;
use App\Repositories\DriverRepositoryInterface;

class DriverRepository implements DriverRepositoryInterface
{
    private $model;

    public function __construct(Driver $driver)
    {
        $this->model = $driver;
    }

    public function createDriver(array $data)
    {
        $newDriver = $this->model->create($data);

        return $newDriver;
    }

    public function getPaginate($nome = null, $cpf = null, $perPage = 5)
    {
        $query = $this->model->orderBy('created_at', 'asc');

        if ($nome !== null) {
            $query->where('nome', 'LIKE', "%{$nome}%");
        }

        if ($cpf !== null) {
            $query->where('cpf', 'LIKE', "%{$cpf}%");
        }

        $drivers = $query->paginate($perPage);

        return $drivers;
    }

    public function getById(string $driverId)
    {
        $driver = $this->model->where('id', $driverId)->first();

        return $driver;
    }
}
