<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\FacialDataRequest;
use App\Models\FacialData;
use App\Repositories\Interfaces\FacialDataRepositoryInterface;
use App\Traits\ResponseTrait;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;

class FacialDataController extends Controller
{

  use ResponseTrait;

  protected $facialDataRepositoryInterface;

  public function __construct(FacialDataRepositoryInterface $facialDataRepositoryInterface)
  {
    $this->facialDataRepositoryInterface = $facialDataRepositoryInterface;
  }
  public function index(Request $request)
  {
    return $this->facialDataRepositoryInterface->get($request);
  }


  public function store(Request $request)
  {
    try {
      $facialDataRequest = new FacialDataRequest();
      $data = $facialDataRequest->validate($request);
      return $this->facialDataRepositoryInterface->create($data);
    } catch (ValidationException $e) {
      return $this->alreadyExist($e->getMessage());
    }
  }

  public function update(Request $request, $id)
  {
    try {
      $facialDataRequest = new FacialDataRequest();
      $data = $facialDataRequest->validate($request);

      return $this->facialDataRepositoryInterface->update($id, $data);
    } catch (ValidationException $e) {
      return $this->alreadyExist($e->getMessage());
    }
  }

  public function destroy($id)
  {
    return $this->facialDataRepositoryInterface->delete($id);
  }
}
