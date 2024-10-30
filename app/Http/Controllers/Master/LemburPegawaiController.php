<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\LemburPegawaiRequest;
use App\Models\LemburPegawai;
use App\Repositories\Interfaces\LemburPegawaiRepositoryInterface;
use App\Traits\ResponseTrait;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LemburPegawaiController extends Controller
{
  use ResponseTrait;
  protected $lemburPegawaiRepositoryInterface;
  public function __construct(LemburPegawaiRepositoryInterface $lemburPegawaiRepositoryInterface)
  {
    $this->lemburPegawaiRepositoryInterface = $lemburPegawaiRepositoryInterface;
  }

  public function index(Request $request)
  {
    return $this->lemburPegawaiRepositoryInterface->get($request);
  }

  public function show($id)
  {
    return LemburPegawai::find($id);
  }

  public function store(Request $request)
  {
    try {
      $lemburPegawaiRequest = new LemburPegawaiRequest();
      $data = $lemburPegawaiRequest->validate($request);
      return $this->lemburPegawaiRepositoryInterface->create($data);
    } catch (ValidationException $e) {
      return $this->wrapResponse(Response::HTTP_BAD_REQUEST, $e->getMessage());
    }
  }

  public function update(Request $request, $id)
  {
    try {
      $lemburPegawaiRequest = new LemburPegawaiRequest();
      $data = $lemburPegawaiRequest->validate($request);
      return $this->lemburPegawaiRepositoryInterface->update($id, $data);
    } catch (ValidationException $e) {
      return $this->wrapResponse(Response::HTTP_BAD_REQUEST, $e->getMessage());
    }
  }

  public function destroy($id)
  {
    try {
      return $this->lemburPegawaiRepositoryInterface->delete($id);
    } catch (\Exception $e) {
      return $this->wrapResponse(Response::HTTP_BAD_REQUEST, $e->getMessage());
    }
  }
}
