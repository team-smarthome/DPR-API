<?php

namespace App\Repositories\Implementations;

use App\Models\LoginPengunjung;
use App\Models\UserPengunjung;
use App\Repositories\Interfaces\AuthPengunjungRepositoryInterface;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthPengunjungRepository implements AuthPengunjungRepositoryInterface
{
  use ResponseTrait;
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

  public function changePassword(array $validatedData, string $id)
  {
    if (!Str::isUuid($id)) {
        return $this->invalidUUid();
    }
    $user = UserPengunjung::where('pengunjung_id', $id)->first();

    
    if (!$user) {
      return $this->wrapResponse(404, 'User not found');
    }

    if (!Hash::check($validatedData['old_password'], $user->password)) {
        return $this->wrapResponse(403, 'Old password is incorrect');
    }


    $user->password = Hash::make($validatedData['new_password']);
    $user->save();

    return $this->wrapResponse(200, 'Password changed successfully');
  }
}
