<?php

namespace App\Repositories\Implementations;

use App\Http\Resources\Auth\UserPengunjungResource;
use App\Models\UserPengunjung;
use App\Repositories\Interfaces\UserPengunjungRepositoryInterface;
use App\Traits\ResponseTrait;
use ErrorException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class UserPengunjungRepository implements UserPengunjungRepositoryInterface
{
  use ResponseTrait;
  public function create(array $data)
  {
    $existingLokasi = UserPengunjung::where('username', $data['username'])->first();

    if ($existingLokasi) {
      return $this->alreadyExist('Username Already Exist');
    }

    return $this->created(UserPengunjung::create($data));
  }

  public function get(Request $request)
  {
    try {
      $collection = UserPengunjung::latest();
      $userId = $request->query("id");
      $isNotPaginate = $request->query("not-paginate");
      $keyword = request()->query("username");

      if ($userId) {
        $collection->where('id', $userId);
      }
      if ($keyword) {
        $collection->where('username', 'ILIKE', "%$keyword%");
      }

      if ($isNotPaginate) {
        $collection = $collection->get();
        $result = UserPengunjungResource::collection($collection)->response()->getData(true);
        return $this->wrapResponse(Response::HTTP_OK, 'Successfully get Data', $result);
      } else {
        return $this->paginate2($collection, 'Successfully get Data', UserPengunjungResource::class);
      }
    } catch (ValidationException $e) {
      return $this->wrapResponse(Response::HTTP_BAD_REQUEST, $e->getMessage());
    } catch (ErrorException $e) {
      return $this->wrapResponse(Response::HTTP_INTERNAL_SERVER_ERROR, 'Terjadi kesalahan internal.');
    } catch (\Throwable $th) {
      return $this->wrapResponse(Response::HTTP_INTERNAL_SERVER_ERROR, 'Terjadi kesalahan: ' . $th->getMessage());
    }
  }

  public function getById(string $id): ?UserPengunjung
  {
    return UserPengunjung::find($id);
  }

  public function update(string $id, array $data): ?UserPengunjung
  {
    $model = UserPengunjung::find($id);
    if ($model) {
      $model->update($data);
      return $model;
    }
    return null;
  }


  public function delete(string $id)
  {
    if (!Str::isUuid($id)) {
      return $this->invalidUUid();
    }
    $model = UserPengunjung::find($id);
    if (!$model) {
      return $this->notFound();
    } else {
      $model->delete();
      return $this->deleted();
    }
  }
}
