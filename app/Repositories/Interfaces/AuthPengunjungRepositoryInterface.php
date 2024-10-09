<?php

namespace App\Repositories\Interfaces;

use App\Models\LoginPengunjung;

interface AuthPengunjungRepositoryInterface
{
  public function login(array $validatedData);

  public function changePassword(array $validatedData, string $id);
}
