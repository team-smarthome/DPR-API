<?php

namespace App\Repositories\Interfaces;

use App\Models\Zona;
use Illuminate\Http\Request;

interface ZonaRepositoryInterface
{
  public function create(array $data);
  public function get(Request $request);
  public function getById(string $id): ?Zona;
  public function update(string $id, array $data);
  public function delete(string $id);
}
