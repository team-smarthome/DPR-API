<?php

namespace App\Repositories\Interfaces;

use App\Models\LoginPengunjung;

interface LoginPengunjungRepositoryInterface
{
  public function login(array $validatedData);
}
