<?php

namespace App\Repositories\Interfaces;

use App\Models\Device;
use Illuminate\Http\Request;

interface DeviceRepositoryInterface
{
    public function create(array $data);
    public function get(Request $request);
    public function getById(string $id): ?Device;
    public function update(string $id, array $data): ?Device;
    public function delete(string $id): bool;
}
