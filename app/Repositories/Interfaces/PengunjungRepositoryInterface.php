<?php

namespace App\Repositories\Interfaces;

use App\Models\Pengunjung;
use Illuminate\Http\Request;

interface PengunjungRepositoryInterface
{
  public function create(array $data);
  public function get(Request $request);
  public function getById(string $id): ?Pengunjung;
  public function update(string $id, array $data);
  public function delete(string $id);
}
