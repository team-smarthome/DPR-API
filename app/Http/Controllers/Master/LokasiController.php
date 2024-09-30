<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\LokasiRequest;
use App\Models\Lokasi;
use App\Repositories\Interfaces\LokasiRepositoryInterface;
use App\Traits\ResponseTrait;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;

class LokasiController extends Controller
{
  use ResponseTrait;

  protected $lokasiRepositoryInterface;

  public function __construct(LokasiRepositoryInterface $lokasiRepositoryInterface)
  {
    $this->lokasiRepositoryInterface = $lokasiRepositoryInterface;
  }

  public function index(Request $request)
  {
    return $this->lokasiRepositoryInterface->get($request);
  }

  public function show($id)
  {
    return Lokasi::find($id);
  }

  public function store(Request $request)
  {
    try {
      $lokasiRequest = new LokasiRequest();
      $data = $lokasiRequest->validate($request);
      return $this->lokasiRepositoryInterface->create($data);
    } catch (ValidationException $e) {
      return $this->alreadyExist('Zona Already Exist');
    }
  }


  public function update(Request $request, $id)
  {
    try {
      $lokasiRequest = new LokasiRequest();
      $data = $lokasiRequest->validate($request);

      return $this->lokasiRepositoryInterface->update($id, $data);
    } catch (ValidationException $e) {
      return $this->alreadyExist('Zona Already Exist');
    }
  }

  public function delete($id)
  {
    return $this->lokasiRepositoryInterface->delete($id);
  }
}
