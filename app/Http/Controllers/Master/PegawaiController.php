<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UpdateIsActivePegawaiRequest;
use App\Http\Requests\Master\CheckCredentialPegawaiRequest;
use App\Http\Requests\Master\FacialDataRequest;
use App\Http\Requests\Master\PegawaiRequest;
use Illuminate\Validation\ValidationException;
use App\Repositories\Interfaces\PegawaiRepositoryInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class PegawaiController extends Controller
{
  use ResponseTrait;

  protected $pegawaiRepositoryInterface;

  public function __construct(PegawaiRepositoryInterface $pegawaiRepositoryInterface)
  {
    $this->pegawaiRepositoryInterface = $pegawaiRepositoryInterface;
  }

  public function index(Request $request)
  {
    return $this->pegawaiRepositoryInterface->get($request);
  }

  public function store(Request $request)
  {
    try {
      $facialRequest = new FacialDataRequest();
      $pegawaiRequest = new PegawaiRequest();

      return $this->pegawaiRepositoryInterface->create(
        [
          'facial_data' => $facialRequest->validate($request),
          'pegawai' =>  $pegawaiRequest->validate($request),
          'user' => [
            'password' => Hash::make($request->input('password')),
          ]
        ]
      );
    } catch (ValidationException $e) {
      return $this->alreadyExist($e->getMessage());
    }
  }

  public function createPegawaiWithoutUser(Request $request)
  {
    try {
      $facialRequest = new FacialDataRequest();
      $pegawaiRequest = new PegawaiRequest();

      $validatedFacialData = $facialRequest->validate($request);
      $validatedPegawaiData = $pegawaiRequest->validate($request);

      $data = [];

      // Jika hanya satu pegawai, bungkus dalam array
      if (!isset($validatedPegawaiData[0])) {
        $data[] = [
          'facial_data' => $validatedFacialData,
          'pegawai' => $validatedPegawaiData,
        ];
      } else {
        // Jika banyak pegawai
        foreach ($validatedPegawaiData as $key => $pegawai) {
          $data[] = [
            'facial_data' => $validatedFacialData[$key] ?? null,
            'pegawai' => $pegawai,
          ];
        }
      }

      return $this->pegawaiRepositoryInterface->createPegawaiWithoutUser($data);
    } catch (ValidationException $e) {
      return $this->alreadyExist($e->getMessage());
    }
  }




  public function update(Request $request, $id)
  {
    try {
      $pegawaiRequest = new PegawaiRequest();
      $data = $pegawaiRequest->validate($request);

      return $this->pegawaiRepositoryInterface->update($id, $data);
    } catch (ValidationException $e) {
      return $this->alreadyExist($e->getMessage());
    }
  }

  public function destroy($id)
  {
    return $this->pegawaiRepositoryInterface->delete($id);
  }

  public function getMe(Request $request)
  {
    return $this->pegawaiRepositoryInterface->getMe($request);
  }

  // public function updateIsActive(Request $request, $id)
  // {
  //   $isActive = $request->input('is_active');

  //   // Validasi nilai is_active
  //   if (!in_array($isActive, [0, 1, 3])) {
  //     return $this->wrapResponse(Response::HTTP_BAD_REQUEST, 'Invalid is_active value');
  //   }

  //   return $this->pegawaiRepositoryInterface->updateIsActive($id, $isActive);
  // }
  public function updateIsActive(Request $request, $id)
  {
    $updateIsActiveRequest = new UpdateIsActivePegawaiRequest();
    $validatedData = $updateIsActiveRequest->validate($request);

    return $this->pegawaiRepositoryInterface->updateIsActive($validatedData, $id);
  }

  public function checkCredentials(Request $request)
  {

    $credentialsRequest = new CheckCredentialPegawaiRequest();
    $validated = $credentialsRequest->validate($request);
    return $this->pegawaiRepositoryInterface->checkCredentials($validated);
  }
}
