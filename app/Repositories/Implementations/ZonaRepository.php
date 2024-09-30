<?php

namespace App\Repositories\Implementations;

use App\Http\Resources\ZonaResource;
use App\Models\Zona;
use App\Repositories\Interfaces\ZonaRepositoryInterface;
use App\Traits\ResponseTrait;
use Dotenv\Exception\ValidationException;
use ErrorException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

class ZonaRepository implements ZonaRepositoryInterface
{
  use ResponseTrait;
  public function create(array $data)
  {
    $existingZona = Zona::where('nama_zona', $data['nama_zona'])->first();

    if ($existingZona) {
      return $this->alreadyExist('Zona Already Exist');
    }

    return $this->created(Zona::create($data));
  }

  public function get(Request $request)
  {
    try {
      $collection = Zona::with('lokasi')->latest(); // Memuat relasi lokasi
      $keyword = $request->query("search");
      $isNotPaginate = $request->query("not-paginate");

      if ($keyword) {
        $collection->where('nama_zona', 'ILIKE', "%$keyword%");
      }

      if ($isNotPaginate) {
        $collection = $collection->get();
        $result = ZonaResource::collection($collection)->response()->getData(true);
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


  public function getById(string $id): ?Zona
  {
    return Zona::find($id);
  }

  public function update(string $id, array $data)
  {
    if (!Str::isUuid($id)) {
      return $this->invalidUUid();
    }

    $model = Zona::find($id);
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

    $model = Zona::find($id);
    if (!$model) {
      return $this->notFound();
    } else {
      $model->delete();
      return $this->deleted();
    }
  }
}
