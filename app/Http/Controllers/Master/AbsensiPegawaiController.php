<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\AbsensiPegawaiRequest;
use App\Repositories\Interfaces\AbsensiPegawaiRepositoryInterface;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class AbsensiPegawaiController extends Controller
{
  use ResponseTrait;

  protected $absensiPegawaiRepositoryInterface;

  public function __construct(AbsensiPegawaiRepositoryInterface $absensiPegawaiRepositoryInterface)
  {
    $this->absensiPegawaiRepositoryInterface = $absensiPegawaiRepositoryInterface;
  }

  public function index(Request $request)
  {
    return $this->absensiPegawaiRepositoryInterface->get($request);
  }


  public function store(Request $request)
  {
    // dd($request->all());
    try {
      $absensiPegawaiRequest = new AbsensiPegawaiRequest();
      $data = $absensiPegawaiRequest->validate($request);
      return $this->absensiPegawaiRepositoryInterface->create($data);
    } catch (ValidationException $e) {
      return $this->wrapResponse(Response::HTTP_BAD_REQUEST, $e->getMessage());
    }
  }

  public function update(Request $request, $id)
  {
    try {
      $absensiPegawaiRequest = new AbsensiPegawaiRequest();
      $data = $absensiPegawaiRequest->validate($request);

      return $this->absensiPegawaiRepositoryInterface->update($id, $data);
    } catch (ValidationException $e) {
      return $this->alreadyExist($e->getMessage());
    }
  }

  public function destroy($id)
  {
    return $this->absensiPegawaiRepositoryInterface->delete($id);
  }
}
