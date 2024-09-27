<?php

namespace App\Repositories\Interfaces;

use App\Models\Lokasi;

interface LokasiRepositoryInterface
{
    public function create(array $data): Lokasi;
    public function get(): array;
    public function getById(string $id): ?Lokasi;
    public function update(string $id, array $data): ?Lokasi;
    public function delete(string $id): bool;
}
