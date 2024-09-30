<?php

namespace App\Repositories\Interfaces;

use App\Models\Lokasi;
use Illuminate\Http\Request;

interface LokasiRepositoryInterface
{
  public function create(array $data);
  public function get(Request $request);
  public function getById(string $id): ?Lokasi;
  public function update(string $id, array $data);
  public function delete(string $id);
}
