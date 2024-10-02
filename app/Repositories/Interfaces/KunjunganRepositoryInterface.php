<?php

namespace App\Repositories\Interfaces;

use App\Models\Kunjungan;
use Illuminate\Http\Request;

interface KunjunganRepositoryInterface
{
  public function create(array $data);
  public function get(Request $request);
  public function getById(string $id);
  public function update(string $id, array $data);
  public function delete(string $id): bool;
}
