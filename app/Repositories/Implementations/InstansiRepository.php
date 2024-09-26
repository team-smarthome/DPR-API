<?php

namespace App\Repositories\Implementations;

use App\Http\Resources\InstansiResource;
use App\Models\Instansi;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\InstansiRepositoryInterface;
use App\Traits\ResponseTrait;

use Symfony\Component\HttpFoundation\Response;

class InstansiRepository implements InstansiRepositoryInterface
{
  use ResponseTrait;
  public function create(array $data): ?Instansi
  {
    $existingInstansi = Instansi::where('nama_instansi', $data['nama_instansi'])->first();
        
    if ($existingInstansi) {
          return null;
    }

        return Instansi::create($data);
  }

  public function get(Request $request)
  {
    try {
      $collection = Instansi::latest();
      $keyword = $request->query("search");
      $isNotPaginate = $request->query("not-paginate");

      if ($keyword) {
        $collection->where('nama_instansi', 'ILIKE', "%$keyword%");
      }

      if ($isNotPaginate) {
        $collection = $collection->get();
        $result = InstansiResource::collection($collection)->response()->getData(true);
        return $this->wrapResponse(Response::HTTP_OK, 'Successfully get Data', $result);
      } else {
        return $this->paginate($collection, null, 'Successfully get Data');
      }
    } catch (ValidationException $e) {
      return $this->wrapResponse(Response::HTTP_BAD_REQUEST, $e->getMessage());
    } catch (ErrorException $e) {
      return $this->wrapResponse(Response::HTTP_INTERNAL_SERVER_ERROR, 'Terjadi kesalahan internal.');
    } catch (\Throwable $th) {
      return $this->wrapResponse(Response::HTTP_INTERNAL_SERVER_ERROR, 'Terjadi kesalahan: ' . $th->getMessage());
    }
  }


  public function getById(string $id): ?Instansi
  {
    return Instansi::find($id);
  }

  public function update(Request $request, $id)
  {
    try {
      $resource = Instansi::findOrFail($id);
      $validatedData = $request->validated();

      if ($resource->update($validatedData)) {
        $resource = (new InstansiResource($resource))
          ->response()
          ->getData(true);

        return $this->wrapResponse(Response::HTTP_OK, 'Data berhasil diperbarui', $resource);
      }
    } catch (\Throwable $th) {
      return $th;
    }
  }

  public function delete(string $id): bool
  {
    $model = Instansi::find($id);
    if (!$model) {
      return false;
    } else {
      return $model->delete();
    }
  }
}
