<?php

namespace App\Repositories\Implementations;

use App\Http\Resources\Master\LokasiResource;
use App\Models\Lokasi;
use App\Repositories\Interfaces\LokasiRepositoryInterface;
use App\Traits\ResponseTrait;
use Dotenv\Exception\ValidationException;
use ErrorException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

class LokasiRepository implements LokasiRepositoryInterface
{
  use ResponseTrait;
  public function create(array $data)
  {
    $existingLokasi = Lokasi::where('nama_lokasi', $data['nama_lokasi'])->first();

    if ($existingLokasi) {
      return $this->alreadyExist('Lokasi Already Exist');
    }

    return $this->created(Lokasi::create($data));
  }

  public function get(Request $request)
  {
    try {
      $collection = Lokasi::latest();
      $keyword = $request->query("search");
      $isNotPaginate = $request->query("not-paginate");

      if ($keyword) {
        $collection->where('nama_lokasi', 'ILIKE', "%$keyword%");
      }

      if ($isNotPaginate) {
        $collection = $collection->get();
        $result = LokasiResource::collection($collection)->response()->getData(true);
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

  public function getById(string $id): ?Lokasi
  {
    return Lokasi::find($id);
  }

  public function update(string $id, array $data)
  {
    if (!Str::isUuid($id)) {
      return $this->invalidUUid();
    }

    $model = Lokasi::find($id);
    if (!$model) {
      return $this->notFound();
    }

    $model->update($data);
    return $this->updated();
  }

  public function delete(string $id)
  {
    if (!Str::isUuid($id)) {
      return $this->invalidUUid();
    }

    $model = Lokasi::find($id);
    if (!$model) {
      return $this->notFound();
    } else {
      $model->delete();
      return $this->deleted();
    }
  }
}
