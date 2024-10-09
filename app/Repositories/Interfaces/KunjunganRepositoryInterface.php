<?php

namespace App\Repositories\Interfaces;

use App\Models\Kunjungan;
use Illuminate\Http\Request;

interface KunjunganRepositoryInterface
{
  public function create(array $data, Request $request);
  public function get(Request $request);
  public function getById(string $id);
  public function update(string $id, array $data, Request $request);
  public function delete(string $id);
}
