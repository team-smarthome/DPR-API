<?php

namespace App\Repositories\Implementations;

use App\Http\Resources\Master\PengunjungResource;
use App\Models\FacialData;
use App\Models\Pengunjung;
use App\Models\Role;
use App\Models\UserPengunjung;
use App\Repositories\Interfaces\PengunjungRepositoryInterface;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\Response;
use Dotenv\Exception\ValidationException;
use ErrorException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class PengunjungRepository implements PengunjungRepositoryInterface
{
  use ResponseTrait;




  public function create(array $data)
  {
    DB::beginTransaction();
    try {
      if (isset($data['facial_data']['face_template']) && $this->isBase64Image($data['facial_data']['face_template'])) {
        $data['facial_data']['face_template'] = $this->saveBase64Image($data['facial_data']['face_template'], 'images/facial_data');
      }

      $facialData = FacialData::create($data['facial_data']);


      $data['pengunjung']['face_id'] = $facialData->id;
      unset($data['pengunjung']['password']);
      $pengunjung = Pengunjung::create($data['pengunjung']);


      $role = Role::where('nama_role', 'users')->first();
      if (!$role) {
        DB::rollBack();
        return $this->wrapResponse(Response::HTTP_BAD_REQUEST, 'Role not found');
      }

      UserPengunjung::create([
        'pengunjung_id' => $pengunjung->id,
        'username' => $data['pengunjung']['nik'],
        'password' => Hash::make($data['password']),
        'role_id' => $role->id,
        'is_suspend' => 0,
        'last_login' => Carbon::now(),
      ]);

      DB::commit();

      return $this->created(['pengunjung' => $pengunjung, 'facial_data' => $facialData]);
    } catch (\Exception $e) {
      Log::info('Facial Data:', $data['facial_data']);
      DB::rollBack();
      return $this->wrapResponse(Response::HTTP_INTERNAL_SERVER_ERROR, 'Terjadi kesalahan: ' . $e->getMessage());
    }
  }




  public function get(Request $request)
  {
    try {
      $collection = Pengunjung::with(['facialData'])->latest();
      $keyword = $request->query("nama_pengunjung");
      $isNotPaginate = $request->query("not-paginate");
      $nik = $request->query("nik");

      if ($keyword) {
        $collection->where('nama_pengunjung', 'ILIKE', "%$keyword%");
      }

      if ($nik) {
        $collection->where('nik', 'ILIKE', "%$nik%");
      }
      if ($isNotPaginate) {
        $collection = $collection->get();
        $result = PengunjungResource::collection($collection)->response()->getData(true);
        return $this->wrapResponse(Response::HTTP_OK, 'Successfully get Data', $result);
      } else {
        return $this->paginate2($collection, 'Successfully get Data', PengunjungResource::class);
      }
    } catch (ValidationException $e) {
      return $this->wrapResponse(Response::HTTP_BAD_REQUEST, $e->getMessage());
    } catch (ErrorException $e) {
      return $this->wrapResponse(Response::HTTP_INTERNAL_SERVER_ERROR, 'Terjadi kesalahan internal.');
    } catch (\Throwable $th) {
      return $this->wrapResponse(Response::HTTP_INTERNAL_SERVER_ERROR, 'Terjadi kesalahan: ' . $th->getMessage());
    }
  }

  public function getById(string $id): ?Pengunjung
  {
    return Pengunjung::find($id);
  }


  public function update(string $id, array $data)
  {
    DB::beginTransaction();
    try {

      $pengunjung = Pengunjung::findOrFail($id);

      if (isset($data['facial_data'])) {
        $facialData = FacialData::findOrFail($pengunjung->face_id);

        if (isset($data['facial_data']['face_template']) && $this->isBase64Image($data['facial_data']['face_template'])) {
          $data['facial_data']['face_template'] = $this->saveBase64Image($data['facial_data']['face_template'], 'images/facial_data');
        }

        $facialData->update($data['facial_data']);
      }

      $pengunjung->update($data['pengunjung']);

      DB::commit();

      return $this->updated();
    } catch (\Exception $e) {
      DB::rollBack();
      return $this->wrapResponse(Response::HTTP_INTERNAL_SERVER_ERROR, 'Terjadi kesalahan: ' . $e->getMessage());
    }
  }
  public function delete(string $id)
  {
    DB::beginTransaction();
    try {
      $pengunjung = Pengunjung::findOrFail($id);

      if ($pengunjung->face_id) {
        $facialData = FacialData::findOrFail($pengunjung->face_id);
        $facialData->delete();
      }


      $pengunjung->delete();

      DB::commit();

      return $this->deleted();
    } catch (\Exception $e) {
      DB::rollBack();
      return $this->wrapResponse(Response::HTTP_INTERNAL_SERVER_ERROR, 'Terjadi kesalahan: ' . $e->getMessage());
    }
  }
}
