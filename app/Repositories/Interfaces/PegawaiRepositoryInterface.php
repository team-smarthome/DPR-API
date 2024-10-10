<?php

namespace App\Repositories\Interfaces;

use App\Models\Pegawai;
use Illuminate\Http\Request;

interface PegawaiRepositoryInterface
{
  public function create(array $data);
  public function get(Request $request);
  public function getById(string $id);
  public function update(string $id, array $data);
  public function delete(string $id);
  public function getMe(Request $request);
  public function updateIsActive(array $validatedData, string $id);
}
