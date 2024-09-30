<?php

namespace App\Repositories\Interfaces;

use App\Models\DeviceZone;
use Illuminate\Http\Request;

interface DeviceZoneRepositoryInterface
{
    public function create(array $data);
    public function get(Request $request);
    public function getById(string $id): ?DeviceZone;
    public function update(string $id, array $data): ?DeviceZone;
    public function delete(string $id): bool;
}
