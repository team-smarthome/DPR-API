<?php

namespace App\Repositories\Implementations;

use App\Http\Resources\Master\UserRoleResource;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\UserRoleRepositoryInterface;
use App\Traits\ResponseTrait;
use Dotenv\Exception\ValidationException;
use ErrorException;
use Illuminate\Support\Str;
use Illuminate\Http\Response;


class UserRoleRepository implements UserRoleRepositoryInterface
{
    use ResponseTrait;
    public function create(array $data)
    {
        $existingRole = Role::where('nama_role', $data['nama_role'])->first();
        
        if ($existingRole) {
            return $this->alreadyExist('Role Already Exist');
        }
    
        return $this->created(Role::create($data));
    }

    public function get(Request $request)
    {
        try {
            $collection = Role::latest();
            $keyword = $request->query("search");
            $isNotPaginate = $request->query("not-paginate");

            if ($keyword) {
                $collection->where('nama_role', 'ILIKE', "%$keyword%");
            }

            if ($isNotPaginate) {
                $collection = $collection->get();
                $result = UserRoleResource::collection($collection)->response()->getData(true);
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

    public function getById(string $id)
    {
        return UserRole::find($id);
    }

    public function update(string $id, array $data)
    {
        if (!Str::isUuid($id)) {
            return $this->invalidUUid();
        }

        $model = Role::find($id);
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

        $model = Role::find($id);
        if (!$model) {
            return $this->notFound();
        }

        $model->delete();
        return $this->deleted();
    }
}
