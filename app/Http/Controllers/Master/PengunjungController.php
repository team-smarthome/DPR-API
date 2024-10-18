<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\FacialDataRequest;
use App\Http\Requests\Master\PengunjungRequest;
use App\Http\Requests\Master\PengunjungWithoutUserRequest;
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
      $facialDataRequest = new FacialDataRequest();

      $pengunjungData = $pengunjungRequest->validate($request);
      $facialData = $facialDataRequest->validate($request);
      return $this->pengunjungRepositoryInterface->create([
        'pengunjung' => $pengunjungData,
        'facial_data' => $facialData,
        'password' => $request->input('password'),
      ]);
    } catch (ValidationException $e) {
      return $this->alreadyExist($e->getMessage());
    }
  }

  public function createPengunjungWithoutUser(Request $request)
  {
    try {
      $pengunjungRequest = new PengunjungWithoutUserRequest();
      $facialDataRequest = new FacialDataRequest();

      $pengunjungData = $pengunjungRequest->validate($request);
      $facialData = $facialDataRequest->validate($request);

      return $this->pengunjungRepositoryInterface->createPengunjungWithoutUser([
        'pengunjung' => $pengunjungData,
        'facial_data' => $facialData,
      ]);
    } catch (ValidationException $e) {
      return $this->alreadyExist($e->getMessage());
    }
  }

  public function update(Request $request, $id)
  {
    try {
      $pengunjungRequest = new PengunjungRequest();
      $data = $pengunjungRequest->validate($request);


      $facialDataRequest = new FacialDataRequest();
      $facialData = $facialDataRequest->validate($request);

      $combinedData = [
        'pengunjung' => $data,
        'facial_data' => $facialData
      ];

      return $this->pengunjungRepositoryInterface->update($id, $combinedData);
    } catch (ValidationException $e) {
      return $this->alreadyExist($e->getMessage());
    }
  }



  public function checkNik(Request $request)
  {
    $nik = $request->query('nik');

    if (!$nik) {
      return response()->json([
        'message' => 'NIK is required'
      ], 400);
    }

    $result = $this->pengunjungRepositoryInterface->checkNik($nik);

    if (!$result['exists_in_pengunjung']) {
      return response()->json([
        'status' => 404,
        'message' => 'NIK does not exist in Pengunjung table'
      ], 404);
    }

    if ($result['exists_in_user_pengunjung']) {
      return response()->json([
        'status' => 200,
        'message' => 'NIK exists in both Pengunjung and user_pengunjung table',
        'pengunjung' => $result['pengunjung']
      ], 200);
    } else {
      return response()->json([
        'status' => 422,
        'message' => 'NIK exists in Pengunjung table but not in user_pengunjung table',
        'pengunjung' => $result['pengunjung']
      ], 422);
    }
  }


  public function delete($id)
  {
    return $this->pengunjungRepositoryInterface->delete($id);
  }
}
