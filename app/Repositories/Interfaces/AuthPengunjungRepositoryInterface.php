<?php

namespace App\Repositories\Interfaces;

use App\Models\LoginPengunjung;
use Illuminate\Http\Request;

interface AuthPengunjungRepositoryInterface
{
  public function login(array $validatedData);

  public function changePassword(array $validatedData, string $id);

  public function updateIsActive(array $validatedData, string $id);
}
