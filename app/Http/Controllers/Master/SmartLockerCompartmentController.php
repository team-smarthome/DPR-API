<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\SmartLockerCompartmentRequest;
use App\Models\SmartLockerCompartment;
use App\Repositories\Interfaces\SmartLockerCompartmentRepositoryInterface;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SmartLockerCompartmentController extends Controller
{

  use ResponseTrait;

  protected $smartLockerCompartementRepositoryInterface;

  public function __construct(SmartLockerCompartmentRepositoryInterface $smartLockerCompartementRepositoryInterface)
  {
    $this->smartLockerCompartementRepositoryInterface = $smartLockerCompartementRepositoryInterface;
  }
  public function index(Request $request)
  {
    return $this->smartLockerCompartementRepositoryInterface->get($request);
  }


  public function store(Request $request)
  {
    try {
      $smartLockRequest = new SmartLockerCompartmentRequest();
      $data = $smartLockRequest->validate($request);
      return $this->smartLockerCompartementRepositoryInterface->create($data);
    } catch (ValidationException $e) {
      return $this->alreadyExist($e->getMessage());
    }
  }

  public function update(Request $request, $id)
  {
    try {
      $smartLockRequest = new SmartLockerCompartmentRequest();
      $data = $smartLockRequest->validate($request);

      return $this->smartLockerCompartementRepositoryInterface->update($id, $data);
    } catch (ValidationException $e) {
      return $this->alreadyExist($e->getMessage());
    }
  }

  public function destroy($id)
  {
    return $this->smartLockerCompartementRepositoryInterface->delete($id);
  }
}
