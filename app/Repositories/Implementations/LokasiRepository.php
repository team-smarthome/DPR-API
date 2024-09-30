<?php

namespace App\Repositories\Implementations;

use App\Models\Lokasi;
use App\Repositories\Interfaces\LokasiRepositoryInterface;

class LokasiRepository implements LokasiRepositoryInterface
{
  public function create(array $data): Lokasi
  {
    return Lokasi::create($data);
  }

  public function get(): array
  {
    return Lokasi::all()->toArray();
  }

  public function getById(string $id): ?Lokasi
  {
    return Lokasi::find($id);
  }

  public function update(string $id, array $data): ?Lokasi
  {
    $model = Lokasi::find($id);
    if ($model) {
      $model->update($data);
      return $model;
    }
    return null;
  }

  public function delete(string $id): bool
  {
    $model = Lokasi::find($id);
    return $model ? $model->delete() : false;
  }
}
