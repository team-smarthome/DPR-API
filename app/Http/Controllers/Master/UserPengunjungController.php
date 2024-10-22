<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UserPengunjungRequest;
use App\Models\UserPengunjung;
use App\Repositories\Interfaces\UserPengunjungRepositoryInterface;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UserPengunjungController extends Controller
{
  use ResponseTrait;

  protected $userPengunjungRepositoryInterface;

  public function __construct(UserPengunjungRepositoryInterface $userPengunjungRepositoryInterface)
  {
    $this->userPengunjungRepositoryInterface = $userPengunjungRepositoryInterface;
  }
  public function index(Request $request)
  {
    return $this->userPengunjungRepositoryInterface->get($request);
  }

  public function show($id)
  {
    return UserPengunjung::find($id);
  }

  public function store(Request $request)
  {
    try {
      $userPengunjungRequest = new UserPengunjungRequest();
      $data = $userPengunjungRequest->validate($request);
      return $this->userPengunjungRepositoryInterface->create($data);
    } catch (ValidationException $e) {
      return $this->alreadyExist('User Role Already Exist');
    }
  }

  public function update(Request $request, $id)
  {
    $model = UserPengunjung::find($id);
    $model->update($request->all());
    return $model;
  }

  public function destroy($id)
  {
    return $this->userPengunjungRepositoryInterface->delete($id);
  }

  public function resetPassword($id)
  {
    return $this->userPengunjungRepositoryInterface->resetPassword($id);
  }
}
