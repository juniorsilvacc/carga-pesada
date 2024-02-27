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
}
