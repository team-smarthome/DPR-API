<?php

namespace App\Repositories\Implementations;

use App\Models\RentSmartLocker;
use App\Repositories\Interfaces\RentSmartLockerRepositoryInterface;

class RentSmartLockerRepository implements RentSmartLockerRepositoryInterface
{
    public function create(array $data): RentSmartLocker
    {
        return RentSmartLocker::create($data);
    }

    public function get(): array
    {
        return RentSmartLocker::all()->toArray();
    }

    public function getById(string $id): ?RentSmartLocker
    {
        return RentSmartLocker::find($id);
    }

    public function update(string $id, array $data): ?RentSmartLocker
    {
        $model = RentSmartLocker::find($id);
        if ($model) {
            $model->update($data);
            return $model;
        }
        return null;
    }

    public function delete(string $id): bool
    {
        $model = RentSmartLocker::find($id);
        return $model ? $model->delete() : false;
    }
}
