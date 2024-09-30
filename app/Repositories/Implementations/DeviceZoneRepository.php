<?php

namespace App\Repositories\Implementations;

use App\Models\DeviceZone;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Http\Resources\DeviceZoneResource;
use App\Repositories\Interfaces\DeviceZoneRepositoryInterface;

class DeviceZoneRepository implements DeviceZoneRepositoryInterface
{
    use ResponseTrait;
    public function create(array $data): DeviceZone
    {
        return DeviceZone::create($data);
    }

    public function get(Request $request)
    {
        try {
            $collection = DeviceZone::with('Device', "Zona")->latest();
            $keyword = $request->query("search");
            $isNotPaginate = $request->query("not-paginate");

            // if($keyword){
            //     $collection->where("")
            // }
            if ($isNotPaginate) {
                $collection = $collection->get();
                $result = DeviceZoneResource::collection($collection)->response()->getData(true);
                return $this->wrapResponse(Response::HTTP_OK, 'Successfully get Data', $result);
            }else{
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

    public function getById(string $id): ?DeviceZone
    {
        return DeviceZone::find($id);
    }

    public function update(string $id, array $data): ?DeviceZone
    {
        $model = DeviceZone::find($id);
        if ($model) {
            $model->update($data);
            return $model;
        }
        return null;
    }

    public function delete(string $id): bool
    {
        $model = DeviceZone::find($id);
        if (!$model) {
            return false;
          } else {
            return $model->delete();
          }
    }
}
