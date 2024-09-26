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
  public function create(array $data): Instansi
  {
    return Instansi::create($data);
  }

  public function get(Request $request)
  {
    try {
      $collection = Instansi::latest();
      $keyword = str($request->query("search"));
      $isNotPaginate = $request->query("not-paginate");

      if ($keyword) {
        $collection->where('nama_instansi', 'ILIKE', "%$keyword%");
      }

      if ($isNotPaginate) {
        $collection = $collection->get();
      } else {
        $collection = $collection
          ->paginate($request->recordsPerPage)
          ->appends(request()->query());
      }

      $result = InstansiResource::collection($collection)
        ->response()
        ->getData(true);

      return $this->wrapResponse(Response::HTTP_OK, 'Data berhasil dimuat', $result);
    } catch (\Throwable $th) {
      return $th;
    }
  }

  public function getById(string $id): ?Instansi
  {
    return Instansi::find($id);
  }

  public function update(string $id, array $data): ?Instansi
  {
    $model = Instansi::find($id);
    if ($model) {
      $model->update($data);
      return $model;
    }
    return null;
  }

  public function delete(string $id): bool
  {
    $model = Instansi::find($id);
    return $model ? $model->delete() : false;
  }
}
