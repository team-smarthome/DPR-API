<?php

namespace App\Repositories\Interfaces;

use App\Models\Zona;
use Illuminate\Http\Request;

interface ZonaRepositoryInterface
{
    public function create($data);
    public function get(Request $request);
    public function getById(string $id): ?Zona;
    public function update(string $id, array $data): ?Zona;
    public function delete(string $id): bool;
}
