<?php

namespace App\Repositories\Interfaces;

use App\Models\DeviceType;
use Illuminate\Http\Request;

interface DeviceTypeRepositoryInterface
{
    public function create(array $data);
    public function get(Request $request);
    public function getById(string $id): ?DeviceType;
    public function update(string $id, array $data);
    public function delete(string $id);
}
