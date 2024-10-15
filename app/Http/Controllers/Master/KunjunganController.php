<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\KunjunganRequest;
use App\Models\Kunjungan;
use App\Repositories\Interfaces\KunjunganRepositoryInterface;
use App\Traits\ResponseTrait;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;

class KunjunganController extends Controller
{

  use ResponseTrait;

  protected $kunjunganRepositoryInterface;

  public function __construct(KunjunganRepositoryInterface $kunjunganRepositoryInterface)
  {
    $this->kunjunganRepositoryInterface = $kunjunganRepositoryInterface;
  }
  public function index(Request $request)
  {
    return $this->kunjunganRepositoryInterface->get($request);
  }


  public function store(Request $request)
  {
    try {
      $kunjungan = new KunjunganRequest();
      $data = $kunjungan->validate($request);
      // $approved_by_id = $request->user_id;
      return $this->kunjunganRepositoryInterface->create($data, $request);
    } catch (ValidationException $e) {
      return $this->alreadyExist($e->getMessage());
    }
  }

  public function update(Request $request, $id)
  {
    try {
      $kunjungan = new KunjunganRequest();
      $data = $kunjungan->validate($request);

      return $this->kunjunganRepositoryInterface->update($id, $data, $request);
    } catch (ValidationException $e) {
      return $this->alreadyExist($e->getMessage());
    }
  }
  public function reschedule(Request $request, $id)
  {
    try {
      $kunjungan = new KunjunganRequest();
      $data = $kunjungan->validate($request);

      return $this->kunjunganRepositoryInterface->reschedule($id, $data);
    } catch (ValidationException $e) {
      return $this->alreadyExist($e->getMessage());
    }
  }


  public function destroy($id)
  {
    return $this->kunjunganRepositoryInterface->delete($id);
  }
}
