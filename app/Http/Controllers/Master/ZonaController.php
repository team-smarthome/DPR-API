<?php

namespace App\Http\Controllers\Master;

use App\Models\Zona;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Master\ZonaRequest;
use Dotenv\Exception\ValidationException;
use App\Repositories\Interfaces\ZonaRepositoryInterface;

class ZonaController extends Controller
{
  use ResponseTrait;

  protected $zonaRepositoryInterface;

  public function __construct(ZonaRepositoryInterface $zonaRepositoryInterface)
  {
    $this->zonaRepositoryInterface = $zonaRepositoryInterface;
  }

  public function index(Request $request)
  {
    return $this->zonaRepositoryInterface->get($request);
  }

  public function show($id)
  {
    return Zona::find($id);
  }

  public function store(Request $request)
  {
      $zonaRequest = new ZonaRequest();
      $data = $zonaRequest->validate($request);

      return $this->zonaRepositoryInterface->create($data);
  }

  public function update(Request $request, $id)
  {
    try {
      $zonaRequest = new ZonaRequest();
      $data = $zonaRequest->validate($request);

      return $this->zonaRepositoryInterface->update($id, $data);
    } catch (ValidationException $e) {
      return $this->alreadyExist('Zona Already Exist');
    }
  }

  public function delete($id)
  {
    return $this->zonaRepositoryInterface->delete($id);
  }
}
