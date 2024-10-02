<?php

namespace App\Repositories\Implementations;

use App\Http\Resources\Master\PengunjungResource;
use App\Models\Pengunjung;
use App\Repositories\Interfaces\PengunjungRepositoryInterface;
use App\Traits\ResponseTrait;
use Symfony\Component\HttpFoundation\Response;
use Dotenv\Exception\ValidationException;
use ErrorException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PengunjungRepository implements PengunjungRepositoryInterface
{
  use ResponseTrait;
  public function create(array $data)
  {
    $existingPengunjung = Pengunjung::where('nama_pengunjung', $data['nama_pengunjung'])->first();

    if ($existingPengunjung) {
      return $this->alreadyExist('Pengunjung Pegawai Already Exist');
    }

    return $this->created(Pengunjung::create($data));
  }

  public function get(Request $request)
  {
    try {
      $collection = Pengunjung::latest();
      $keyword = $request->query("search");
      $isNotPaginate = $request->query("not-paginate");

      if ($keyword) {
        $collection->where('nama_pengunjung', 'ILIKE', "%$keyword%");
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
    if (!Str::isUuid($id)) {
      return $this->invalidUUid();
    }

    $model = Pengunjung::find($id);
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

    $model = Pengunjung::find($id);
    if (!$model) {
      return $this->notFound();
    } else {
      $model->delete();
      return $this->deleted();
    }
  }
}
