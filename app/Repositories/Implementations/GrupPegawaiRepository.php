<?php

namespace App\Repositories\Implementations;

use App\Models\GrupPegawai;
use App\Repositories\Interfaces\GrupPegawaiRepositoryInterface;

class GrupPegawaiRepository implements GrupPegawaiRepositoryInterface
{
    public function create(array $data): GrupPegawai
    {
        return GrupPegawai::create($data);
    }

    public function get(): array
    {
        return GrupPegawai::all()->toArray();
    }

    public function getById(string $id): ?GrupPegawai
    {
        return GrupPegawai::find($id);
    }

    public function update(string $id, array $data): ?GrupPegawai
    {
        $model = GrupPegawai::find($id);
        if ($model) {
            $model->update($data);
            return $model;
        }
        return null;
    }

    public function delete(string $id): bool
    {
        $model = GrupPegawai::find($id);
        return $model ? $model->delete() : false;
    }
}
