<?php

namespace App\Repositories\Implementations;

use App\Http\Resources\Master\GrupPegawaiResource;
use App\Http\Resources\Master\GrupKunjunganResponseResource;
use App\Models\GrupPegawai;
use App\Models\Pegawai;
use App\Repositories\Interfaces\GrupPegawaiRepositoryInterface;
use App\Traits\ResponseTrait;
use Dotenv\Exception\ValidationException;
use Illuminate\Support\Facades\DB;
use ErrorException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;
use Carbon\Carbon;

class GrupPegawaiRepository implements GrupPegawaiRepositoryInterface
{
  use ResponseTrait;
  public function create(array $data)
  {
    DB::beginTransaction();
    try {
      $existingGrupPegawai = GrupPegawai::where('nama_grup_pegawai', $data['nama_grup_pegawai'])->first();
      if ($existingGrupPegawai) {
        return $this->alreadyExist('Grup Pegawai Already Exist');
      }
      $grupPegawai = GrupPegawai::create($data);

      if (isset($data['pegawai'])) {
        Pegawai::whereIn('id', $data['pegawai'])->update(['grup_pegawai_id' => $grupPegawai->id]);
      }

      if (isset($data['ketua_grup'])) {
        $pegawai = Pegawai::find($data['ketua_grup']);
        if ($pegawai) {
          $pegawai->update([
            'grup_pegawai_id' => $grupPegawai->id
          ]);
        } else {
          throw new Exception('Pegawai not found');
        }
      }

      DB::commit();
      return $this->created($grupPegawai);
    } catch (Exception $e) {
      DB::rollBack();
      return $this->error($e->getMessage(), 500);
    }
  }

  public function get(Request $request)
  {
    try {
      $collection = GrupPegawai::with('pegawai')->latest();
      $keyword = $request->query("search");
      $isNotPaginate = $request->query("not-paginate");

      if ($keyword) {
        $collection->where('nama_grup_pegawai', 'ILIKE', "%$keyword%");
      }

      if ($isNotPaginate) {
        $collection = GrupPegawai::latest()->get();
        $result = GrupPegawaiResource::collection($collection)->response()->getData(true);
        return $this->wrapResponse(Response::HTTP_OK, 'Successfully get Data', $result);
      } else {
        $result = GrupKunjunganResponseResource::collection($collection->paginate($request->query('per_page', self::$defaultPagination)))->response()->getData(true);
        return $this->wrapResponse(Response::HTTP_OK, 'Successfully get Data', $result);
      }
    } catch (ValidationException $e) {
      return $this->wrapResponse(Response::HTTP_BAD_REQUEST, $e->getMessage());
    } catch (ErrorException $e) {
      return $this->wrapResponse(Response::HTTP_INTERNAL_SERVER_ERROR, 'Terjadi kesalahan internal.');
    } catch (\Throwable $th) {
      return $this->wrapResponse(Response::HTTP_INTERNAL_SERVER_ERROR, 'Terjadi kesalahan: ' . $th->getMessage());
    }
  }

  public function getById(string $id): ?GrupPegawai
  {
    return GrupPegawai::find($id);
  }

  public function update(string $id, array $data)
  {
    try {
      if (!Str::isUuid($id)) {
        return $this->invalidUUid();
      }

      $model = GrupPegawai::find($id);
      if (!$model) {
        return $this->notFound();
      }


      if (isset($data['nama_grup_pegawai'])) {
        $existingGrupPegawai = GrupPegawai::where('nama_grup_pegawai', $data['nama_grup_pegawai'])
          ->where('id', '!=', $id)
          ->first();

        if ($existingGrupPegawai) {
          return $this->alreadyExist('Grup Pegawai with this name already exists');
        }
      }


      $model->update($data);
      return $this->updated($model);
    } catch (ValidationException $e) {
      return $this->wrapResponse(Response::HTTP_BAD_REQUEST, $e->getMessage());
    } catch (\Exception $e) {
      return $this->wrapResponse(Response::HTTP_INTERNAL_SERVER_ERROR, 'Terjadi kesalahan saat memperbarui data. ' . $e->getMessage());
    }
  }


  public function delete(string $id)
  {
    if (!Str::isUuid($id)) {
      return $this->invalidUUid();
    }

    $model = GrupPegawai::find($id);
    if (!$model) {
      return $this->notFound();
    }

    $model->delete();
    return $this->deleted();
  }
}
