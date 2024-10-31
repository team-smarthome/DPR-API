<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\WfhPegawaiRequest;
use App\Repositories\Interfaces\WfhPegawaiRepositoryInterface;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use Illuminate\Validation\ValidationException;

class WfhPegawaiController extends Controller
{
  use ResponseTrait;

  protected $wfhPegawaiRepositoryInterface;

  public function __construct(WfhPegawaiRepositoryInterface $wfhPegawaiRepositoryInterface)
  {
    $this->wfhPegawaiRepositoryInterface = $wfhPegawaiRepositoryInterface;
  }

  public function index(Request $request)
  {
    return $this->wfhPegawaiRepositoryInterface->get($request);
  }

  public function store(Request $request)
  {
    try {
      $wfhPegawaiRequest = new WfhPegawaiRequest();
      $data = $wfhPegawaiRequest->validate($request);
      return $this->wfhPegawaiRepositoryInterface->create($data);
    } catch (ValidationException $e) {
      return $this->alreadyExist($e->getMessage());
    }
  }

  public function update(Request $request, $id)
  {
    try {
      $wfhPegawaiRequest = new WfhPegawaiRequest();
      $data = $wfhPegawaiRequest->validate($request);

      return $this->wfhPegawaiRepositoryInterface->update($id, $data);
    } catch (ValidationException $e) {
      return $this->alreadyExist($e->getMessage());
    }
  }

  public function destroy($id)
  {
    return $this->wfhPegawaiRepositoryInterface->delete($id);
  }
}
