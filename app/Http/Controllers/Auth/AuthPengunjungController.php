<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginPengunjungRequest;
use App\Http\Requests\Auth\ChangePasswordPengunjungRequest;
use App\Http\Resources\Auth\UserPengunjungResource;
use App\Models\UserPengunjung;
use App\Repositories\Interfaces\AuthPengunjungRepositoryInterface;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthPengunjungController extends Controller
{
  use ResponseTrait;

  protected $loginPengunjungRepository;

  public function __construct(AuthPengunjungRepositoryInterface $loginPengunjungRepository)
  {
    $this->loginPengunjungRepository = $loginPengunjungRepository;
  }

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

  public function changePassword(Request $request, $id)
  {
    $changePasswordRequest = new ChangePasswordPengunjungRequest();
    $validatedData = $changePasswordRequest->validate($request);

    return $this->loginPengunjungRepository->changePassword($validatedData, $id);
  }
}
