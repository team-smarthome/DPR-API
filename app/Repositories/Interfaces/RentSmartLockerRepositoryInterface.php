<?php

namespace App\Repositories\Interfaces;

use App\Models\RentSmartLocker;

interface RentSmartLockerRepositoryInterface
{
    public function create(array $data): RentSmartLocker;
    public function get(): array;
    public function getById(string $id): ?RentSmartLocker;
    public function update(string $id, array $data): ?RentSmartLocker;
    public function delete(string $id): bool;
}
