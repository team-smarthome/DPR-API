<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\PengunjungRequest;
use App\Models\Pengunjung;
use App\Repositories\Interfaces\PengunjungRepositoryInterface;
use App\Traits\ResponseTrait;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;

class PengunjungController extends Controller
{
  use ResponseTrait;

  protected $pengunjungRepositoryInterface;

  public function __construct(PengunjungRepositoryInterface $pengunjungRepositoryInterface)
  {
    $this->pengunjungRepositoryInterface = $pengunjungRepositoryInterface;
  }
  public function index(Request $request)
  {
    return $this->pengunjungRepositoryInterface->get($request);
  }

  public function show($id)
  {
    return Pengunjung::find($id);
  }

  public function store(Request $request)
  {
    try {
      $pengunjungRequest = new PengunjungRequest();
      $data = $pengunjungRequest->validate($request);
      return $this->pengunjungRepositoryInterface->create($data);
    } catch (ValidationException $e) {
      return $this->alreadyExist($e->getMessage());
    }
  }

  public function update(Request $request, $id)
  {
    try {
      $pengunjungRequest = new PengunjungRequest();
      $data = $pengunjungRequest->validate($request);

      return $this->pengunjungRepositoryInterface->update($id, $data);
    } catch (ValidationException $e) {
      return $this->alreadyExist($e->getMessage());
    }
  }

  public function destroy($id)
  {
    return $this->pengunjungRepositoryInterface->delete($id);
  }
}
