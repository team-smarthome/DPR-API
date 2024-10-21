<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\UserPengunjung;
use App\Repositories\Interfaces\UserPengunjungRepositoryInterface;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

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
    return UserPengunjung::create($request->all());
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
}
