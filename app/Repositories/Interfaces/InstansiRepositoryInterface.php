<?php

namespace App\Repositories\Interfaces;

use App\Models\Instansi;
use Illuminate\Http\Request;

interface InstansiRepositoryInterface
{
   public function create(array $data);
  public function get(Request $request);
  public function getById(string $id): ?Instansi;
  public function update(string $id, array $data): ?Instansi;
  public function delete(string $id): bool;
}
