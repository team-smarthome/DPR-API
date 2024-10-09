<?php

namespace App\Repositories\Implementations;

use App\Http\Resources\Master\UserResource;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Traits\ResponseTrait;
use ErrorException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class UserRepository implements UserRepositoryInterface
{
  use ResponseTrait;
  public function create(array $data)
  {
    return User::create($data);
  }

  public function get(Request $request)
  {
    try {
      $collection = User::latest();
      $isNotPaginate = $request->query("not-paginate");

      if ($isNotPaginate) {
        $collection = $collection->get();
        $result = UserResource::collection($collection)->response()->getData(true);
        return $this->wrapResponse(Response::HTTP_OK, 'Successfully get Data', $result);
      } else {
        return $this->paginate2($collection, 'Successfully get Data', UserResource::class);
      }
    } catch (ValidationException $e) {
      return $this->wrapResponse(Response::HTTP_BAD_REQUEST, $e->getMessage());
    } catch (ErrorException $e) {
      return $this->wrapResponse(Response::HTTP_INTERNAL_SERVER_ERROR, 'Terjadi kesalahan internal.' . $e->getMessage());
    } catch (\Throwable $th) {
      return $this->wrapResponse(Response::HTTP_INTERNAL_SERVER_ERROR, 'Terjadi kesalahan: ' . $th->getMessage());
    }
  }

  public function getById(string $id): ?User
  {
    return User::find($id);
  }

  public function update(string $id, array $data): ?User
  {
    $model = User::find($id);
    if ($model) {
      $model->update($data);
      return $model;
    }
    return null;
  }

  public function delete(string $id): bool
  {
    $model = User::find($id);
    return $model ? $model->delete() : false;
  }
}
