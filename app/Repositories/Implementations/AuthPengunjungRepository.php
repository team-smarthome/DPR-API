<?php

namespace App\Repositories\Implementations;

use App\Models\LoginPengunjung;

use App\Models\Pengunjung;
use App\Models\UserPengunjung;
use App\Repositories\Interfaces\AuthPengunjungRepositoryInterface;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

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
    print_r($user->pengunjung_id);
    $pegawai = Pengunjung::where('id', $user->pengunjung_id)->first();
    if ($pegawai->is_active == 0) {
      return $this->wrapResponse(403, 'User is inactive');
    } elseif ($pegawai->is_active == 2) {
      return $this->wrapResponse(403, 'User is rejected');
    }
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

  public function updateIsActive(array $validatedData, string $id)
  {
    // Validasi UUID
    if (!Str::isUuid($id)) {
      return $this->wrapResponse(400, 'Invalid UUID');
    }

    // Mencari user pengunjung berdasarkan ID
    $user = Pengunjung::find($id);
    if (!$user) {
      return $this->wrapResponse(404, 'User not found');
    }

    // Update nilai is_active
    $user->is_active = $validatedData['is_active'];
    $user->save();

    return $this->wrapResponse(200, 'User updated successfully');
  }
}
