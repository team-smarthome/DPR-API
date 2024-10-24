<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\UserRequest;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Traits\ResponseTrait;
use Illuminate\Console\PromptValidationException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
  use ResponseTrait;

  protected $usersRepositoryInterface;

  public function __construct(UserRepositoryInterface $usersRepositoryInterface)
  {
    $this->usersRepositoryInterface = $usersRepositoryInterface;
  }
  public function index(Request $request)
  {
    return $this->usersRepositoryInterface->get($request);
  }

  public function show($id)
  {
    return User::find($id);
  }

  public function store(Request $request)
  {
    try {
      $userRequest = new UserRequest();
      $data = $userRequest->validate($request);
      return $this->usersRepositoryInterface->create($data);
    } catch (ValidationException $e) {
      return $this->alreadyExist($e->getMessage());
    }
  }

  public function update(Request $request, $id)
  {
    $model = User::find($id);
    $model->update($request->all());
    return $model;
  }

  public function destroy($id)
  {
    return $this->usersRepositoryInterface->delete($id);
  }

  public function updateRoleId(Request $request, $id)
  {
    $roleId = $request->input('roleId');
    return $this->usersRepositoryInterface->updateRoleId($roleId, $id);
  }
  public function resetPassword($id)
  {
    return $this->usersRepositoryInterface->resetPassword($id);
  }
}
