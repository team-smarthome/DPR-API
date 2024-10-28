<?php

namespace App\Repositories\Implementations;

use ErrorException;
use App\Models\Pegawai;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\DB;
use Dotenv\Exception\ValidationException;
use App\Http\Resources\Master\PegawaiResource;
use App\Models\FacialData;
use App\Models\GrupPegawai;
use App\Models\Jabatan;
use App\Models\Role;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use App\Repositories\Interfaces\PegawaiRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PegawaiRepository implements PegawaiRepositoryInterface
{
  use ResponseTrait;

  public function create(array $data)
  {

    try {
      DB::beginTransaction();

      // ** Check NIP ** //
      $existingNip = Pegawai::where('nip', $data['pegawai']['nip'])->first();
      if ($existingNip) {
        DB::rollBack();
        return $this->wrapResponse(Response::HTTP_CONFLICT, 'NIP already exists');
      }

      if (isset($data['facial_data']['face_template']) && $this->isBase64Image($data['facial_data']['face_template'])) {
        $data['facial_data']['face_template'] = $this->saveBase64Image($data['facial_data']['face_template'], 'images/facial_data');
      }

      //** FacialData **//
      $facial = FacialData::create($data['facial_data']);

      //** PegawaiData **//
      $pegawaiData = array_merge($data['pegawai'], ['face_id' => $facial->id]);
      $pegawai = Pegawai::create($pegawaiData);

      //** UserData **//
      $role = Role::where('nama_role', 'users')->first();
      $userData = array_merge($data['user'], ['pegawai_id' => $pegawai->id, 'username' => $pegawai->nip, 'role_id' => $role->id]);
      $user = User::create($userData);

      DB::commit();
      return $this->created(['facial_data' => $facial, 'pegawai' => $pegawai, 'user' => $user]);
    } catch (\Exception $e) {
      DB::rollBack();
      return $this->wrapResponse(Response::HTTP_INTERNAL_SERVER_ERROR, 'Terjadi kesalahan: ' . $e->getMessage());
    }
  }

  public function createPegawaiWithoutUser(array $data)
  {
    try {
      DB::beginTransaction();
      $createdPegawai = [];

      foreach ($data as $pegawaiData) {
        $jabatan = Jabatan::whereRaw('LOWER(nama_jabatan) = ?', [strtolower($pegawaiData['pegawai']['nama_jabatan'])])->first();
        $grupPegawai = GrupPegawai::whereRaw('LOWER(nama_grup_pegawai) = ?', [strtolower($pegawaiData['pegawai']['nama_grup_pegawai'])])->first();
        if (!$jabatan) {
          DB::rollBack();
          return $this->wrapResponse(Response::HTTP_NOT_FOUND, 'Jabatan tidak ditemukan');
        }

        if (!$grupPegawai) {
          DB::rollBack();
          return $this->wrapResponse(Response::HTTP_NOT_FOUND, 'Grup Pegawai tidak ditemukan');
        }

        $pegawaiData['pegawai']['jabatan_id'] = $jabatan->id;
        unset($pegawaiData['pegawai']['nama_jabatan']);

        $pegawaiData['pegawai']['grup_pegawai_id'] = $grupPegawai->id;
        unset($pegawaiData['pegawai']['nama_grup_pegawai']);
        $existingNip = Pegawai::where('nip', $pegawaiData['pegawai']['nip'])->first();
        if ($existingNip) {
          DB::rollBack();
          return $this->wrapResponse(Response::HTTP_CONFLICT, 'NIP already exists');
        }

        if (isset($pegawaiData['facial_data']['face_template']) && $this->isBase64Image($pegawaiData['facial_data']['face_template'])) {
          $pegawaiData['facial_data']['face_template'] = $this->saveBase64Image($pegawaiData['facial_data']['face_template'], 'images/facial_data');
        }

        $facial = FacialData::create($pegawaiData['facial_data']);
        $pegawaiData = array_merge($pegawaiData['pegawai'], ['face_id' => $facial->id]);
        $pegawai = Pegawai::create($pegawaiData);

        $createdPegawai[] = [
          'facial_data' => $facial,
          'pegawai' => $pegawai,
        ];
      }

      DB::commit();
      return $this->created($createdPegawai);
    } catch (\Throwable $th) {
      DB::rollBack();
      return $this->wrapResponse(Response::HTTP_INTERNAL_SERVER_ERROR, 'Terjadi kesalahan saat membuat data pegawai.' . $th->getMessage());
    }
  }


  // public function createPegawaiWithoutUser(array $data)
  // {
  //   try {
  //     DB::beginTransaction();

  //     $createdPegawai = [];

  //     foreach ($data as $pegawaiData) {
  //       // ** Check NIP ** //
  //       $existingNip = Pegawai::where('nip', $pegawaiData['pegawai']['nip'])->first();
  //       if ($existingNip) {
  //         DB::rollBack();
  //         return $this->wrapResponse(Response::HTTP_CONFLICT, 'NIP already exists');
  //       }

  //       if (isset($pegawaiData['facial_data']['face_template']) && $this->isBase64Image($pegawaiData['facial_data']['face_template'])) {
  //         $pegawaiData['facial_data']['face_template'] = $this->saveBase64Image($pegawaiData['facial_data']['face_template'], 'images/facial_data');
  //       }

  //       $facial = FacialData::create($pegawaiData['facial_data']);

  //       $pegawaiData = array_merge($pegawaiData['pegawai'], ['face_id' => $facial->id]);
  //       $pegawai = Pegawai::create($pegawaiData);

  //       $createdPegawai[] = [
  //         'facial_data' => $facial,
  //         'pegawai' => $pegawai,
  //       ];
  //     }

  //     DB::commit();
  //     return $this->created($createdPegawai);
  //   } catch (\Throwable $th) {
  //     DB::rollBack();
  //     return $this->wrapResponse(Response::HTTP_INTERNAL_SERVER_ERROR, 'Terjadi kesalahan saat membuat data pegawai.' . $th->getMessage());
  //   }
  // }



  public function get(Request $request)
  {
    try {
      $collection = Pegawai::with(['jabatan.instansi', 'palmData', 'facialData', 'grupPegawai'])->latest();
      $keyword = $request->query("search");
      $isNotPaginate = $request->query("not-paginate");

      if ($keyword) {
        $collection->where('nama_pegawai', 'ILIKE', "%$keyword%");
      }

      if ($isNotPaginate) {
        $collection = $collection->get();
        $result = PegawaiResource::collection($collection)->response()->getData(true);
        return $this->wrapResponse(Response::HTTP_OK, 'Successfully get Data', $result);
      } else {
        return $this->paginate2($collection, 'Successfully get Data', PegawaiResource::class);
      }
    } catch (ValidationException $e) {
      return $this->wrapResponse(Response::HTTP_BAD_REQUEST, $e->getMessage());
    } catch (ErrorException $e) {
      return $this->wrapResponse(Response::HTTP_INTERNAL_SERVER_ERROR, 'Terjadi kesalahan internal.');
    } catch (\Throwable $th) {
      return $this->wrapResponse(Response::HTTP_INTERNAL_SERVER_ERROR, 'Terjadi kesalahan: ' . $th->getMessage());
    }
  }

  public function getById(string $id): ?Pegawai
  {
    return Pegawai::find($id);
  }

  public function update(string $id, array $data)
  {
    if (!Str::isUuid($id)) {
      return $this->invalidUUid();
    }

    $model = Pegawai::find($id);
    if (!$model) {
      return $this->notFound();
    }

    DB::beginTransaction();

    try {
      $model->update($data);
      if (isset($data['role_id'])) {
        $user = User::where('pegawai_id', $id)->first();
        if ($user) {
          $user->role_id = $data['role_id'];
          $user->save();
        }
      }
      DB::commit();

      return $this->updated();
    } catch (\Exception $e) {
      DB::rollBack();
      return $this->error($e->getMessage());
    }
  }

  public function delete(string $id)
  {
    if (!Str::isUuid($id)) {
      return $this->invalidUUid();
    }

    $model = Pegawai::find($id);
    if (!$model) {
      return $this->notFound();
    }

    $model->delete();
    return $this->deleted();
  }

  public function getMe(Request $request)
  {
    $userId = $request->user_id;
    $pegawai = Pegawai::with(['jabatan.instansi', 'palmData', 'facialData', 'grupPegawai'])
      ->where('id', $userId)
      ->first();

    if ($pegawai) {
      $roleId =  $request->role_id;
      $roleName = $request->nama_role;

      $pegawaiResource = new PegawaiResource($pegawai, $userId, $roleId, $roleName);
      $result = $pegawaiResource->toArray($request);

      return $this->wrapResponse2(Response::HTTP_OK, 'Successfully get Data', $result);
    }
    return $this->wrapResponse2(Response::HTTP_NOT_FOUND, 'Data not found');
  }



  public function updateIsActive(array $validatedData, string $id)
  {
    if (!Str::isUuid($id)) {
      return $this->wrapResponse(400, 'Invalid UUID');
    }

    // Mencari user pengunjung berdasarkan ID
    $user = Pegawai::find($id);
    if (!$user) {
      return $this->wrapResponse(404, 'Pegawai not found');
    }

    // Update nilai is_active
    $user->is_active = $validatedData['is_active'];
    $user->save();

    return $this->wrapResponse(200, 'Pegawai updated successfully');
  }
  public function checkCredentials(array $credentials)
  {
    try {
      $user = User::where('username', $credentials['username'])->first();

      if ($user && Hash::check($credentials['password'], $user->password)) {
        return $this->wrapResponse2(Response::HTTP_OK, 'Credentials are valid', ['user_id' => $user->id]);
      }

      return $this->wrapResponse(Response::HTTP_UNAUTHORIZED, 'Invalid credentials');
    } catch (\Exception $e) {
      return $this->wrapResponse(Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
    }
  }
}
