<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginPengunjungRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\Auth\UserPengunjungResource;
use App\Http\Resources\Auth\UserPengunjungResourceResource;
use App\Models\LoginPengunjung;
use App\Models\UserPengunjung;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginPengunjungController extends Controller
{
  use ResponseTrait;

  public function login(Request $request)
  {
    $loginPengunjungRequest = new LoginPengunjungRequest();
    $validatedData = $loginPengunjungRequest->validate($request);

    // Mencari user berdasarkan username
    $user = UserPengunjung::where('username', $validatedData['username'])->first();

    if (!$user || !Hash::check($validatedData['password'], $user->password)) {
      return $this->wrapResponse(401, 'Unauthorized');
    }

    // Update last_login
    $user->last_login = Carbon::now();
    $user->save();

    $resource = new UserPengunjungResource($user);

    return $this->wrapResponse(200, 'Login Successfully', ['data' => $resource]);
  }
}
