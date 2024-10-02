<?php

namespace App\Repositories\Implementations;

use App\Models\Kunjungan;
use App\Repositories\Interfaces\KunjunganRepositoryInterface;
use Illuminate\Http\Request;

class KunjunganRepository implements KunjunganRepositoryInterface
{
  public function create(array $data): Kunjungan
  {
    return Kunjungan::create($data);
  }

  public function get(Request $request)
  {
    return Kunjungan::all()->toArray();
  }

  public function getById(string $id): ?Kunjungan
  {
    return Kunjungan::find($id);
  }

  public function update(string $id, array $data): ?Kunjungan
  {
    $model = Kunjungan::find($id);
    if ($model) {
      $model->update($data);
      return $model;
    }
    return null;
  }

  public function delete(string $id): bool
  {
    $model = Kunjungan::find($id);
    return $model ? $model->delete() : false;
  }
}
