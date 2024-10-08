<?php

namespace App\Repositories\Implementations;

use App\Models\LoginPengunjung;
use App\Models\UserPengunjung;
use App\Repositories\Interfaces\LoginPengunjungRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class LoginPengunjungRepository implements LoginPengunjungRepositoryInterface
{
  public function login(array $validatedData)
  {
    // Mencari user berdasarkan username
    $user = UserPengunjung::where('username', $validatedData['username'])->first();

    if (!$user || !Hash::check($validatedData['password'], $user->password)) {
      return null;
    }

    // Update last_login
    $user->last_login = Carbon::now();
    $user->save();

    return $user;
  }
}
