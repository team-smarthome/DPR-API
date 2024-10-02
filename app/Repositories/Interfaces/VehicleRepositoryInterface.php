<?php

namespace App\Repositories\Interfaces;

use App\Models\Vehicle;
use Illuminate\Http\Request;

interface VehicleRepositoryInterface
{
    public function create(array $data);
    public function get(Request $request);
    public function getById(string $id);
    public function update(string $id, array $data);
    public function delete(string $id);
}
