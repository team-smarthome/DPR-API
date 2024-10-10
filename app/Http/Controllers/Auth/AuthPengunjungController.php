<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginPengunjungRequest;
use App\Http\Requests\Auth\ChangePasswordPengunjungRequest;
use App\Http\Requests\Auth\UpdateIsActivePengunjungRequest;
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

    // Mengecek nilai is_active pada user pengunjung
    if ($user->is_active == 0) {
      return $this->wrapResponse(403, 'User is inactive');
    } elseif ($user->is_active == 2) {
      return $this->wrapResponse(403, 'User is rejected');
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
  public function updateIsActive(Request $request, $id)
  {
    $updateIsActiveRequest = new UpdateIsActivePengunjungRequest();
    $validatedData = $updateIsActiveRequest->validate($request);

    return $this->loginPengunjungRepository->updateIsActive($validatedData, $id);
  }
}
