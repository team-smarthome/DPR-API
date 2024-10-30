<?php

namespace App\Repositories\Interfaces;

use App\Models\LemburPegawai;
use Illuminate\Http\Request;

interface LemburPegawaiRepositoryInterface
{
  public function create(array $data);
  public function get(Request $request);
  public function getById(string $id);
  public function update(string $id, array $data);
  public function delete(string $id);
}
