<?php

namespace App\Repositories\Interfaces;

use App\Models\PermohonanAbsensi;
use Illuminate\Http\Request;

interface PermohonanAbsensiRepositoryInterface
{
  public function create(array $data);
  public function get(Request $request);
  public function getById(string $id);
  public function update(string $id, array $data);
  public function delete(string $id);
}
