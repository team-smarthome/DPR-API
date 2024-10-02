<?php

namespace App\Repositories\Implementations;

use App\Http\Resources\Master\DeviceTypeResource;
use App\Models\DeviceType;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\DeviceTypeRepositoryInterface;
use App\Traits\ResponseTrait;
use Dotenv\Exception\ValidationException;
use ErrorException;
use Illuminate\Support\Str;


class DeviceTypeRepository implements DeviceTypeRepositoryInterface
{
    use ResponseTrait;
    public function create(array $data)
    {
        $existingDevice = DeviceType::where('nama', $data['nama'])->first();
        
        if ($existingDevice) {
            return $this->alreadyExist('Device Type Already Exist');
        }
    
         return $this->created(DeviceType::create($data));
    }

    public function get(Request $request)
    {
        try {
            $collection = DeviceType::latest();
            $keyword = $request->query("search");
            $isNotPaginate = $request->query("not-paginate");
  
            if ($keyword) {
                $collection->where('nama', 'ILIKE', "%$keyword%");
            }
  
            if ($isNotPaginate) {
                $collection = $collection->get();
                $result = DeviceTypeResource::collection($collection)->response()->getData(true);
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

    public function getById(string $id): ?DeviceType
    {
        return DeviceType::find($id);
    }

    public function update(string $id, array $data)
    {
        if (!Str::isUuid($id)) {
            return $this->invalidUUid();
        }

        $model = DeviceType::find($id);
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

        $model = DeviceType::find($id);
        if (!$model) {
            return $this->notFound();
        }

        $model->delete();
        return $this->deleted();
    }
}
