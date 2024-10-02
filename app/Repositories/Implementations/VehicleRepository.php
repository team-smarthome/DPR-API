<?php

namespace App\Repositories\Implementations;

use App\Http\Resources\Master\VehicleResource;
use App\Models\Vehicle;
use App\Repositories\Interfaces\VehicleRepositoryInterface;
use App\Traits\ResponseTrait;
use Dotenv\Exception\ValidationException;
use ErrorException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

class VehicleRepository implements VehicleRepositoryInterface
{
    use ResponseTrait;
    public function create(array $data)
    {  
        return $this->created(Vehicle::create($data));
    }

    public function get(Request $request)
    {
        try {
            $collection = Vehicle::with(['pegawai', 'pengunjung', 'grupVehiclePegawai'])->latest();
            $isNotPaginate = $request->query("not-paginate");

            if ($isNotPaginate) {
                $collection = $collection->get();
                $result = VehicleResource::collection($collection)->response()->getData(true);
                return $this->wrapResponse(Response::HTTP_OK, 'Successfully get Data', $result);
            } else {
                return $this->paginate2($collection, 'Successfully get Data', VehicleResource::class);
            }
        } catch (ValidationException $e) {
            return $this->wrapResponse(Response::HTTP_BAD_REQUEST, $e->getMessage());
        } catch (ErrorException $e) {
            return $this->wrapResponse(Response::HTTP_INTERNAL_SERVER_ERROR, 'Terjadi kesalahan internal.');
        } catch (\Throwable $th) {
            return $this->wrapResponse(Response::HTTP_INTERNAL_SERVER_ERROR, 'Terjadi kesalahan: ' . $th->getMessage());
        }
    }

    public function getById(string $id): ?Vehicle
    {
        return Vehicle::find($id);
    }

    public function update(string $id, array $data)
    {
        if (!Str::isUuid($id)) {
            return $this->invalidUUid();
        }

        $model = Vehicle::find($id);
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

        $model = Vehicle::find($id);
        if (!$model) {
            return $this->notFound();
        }

        $model->delete();
        return $this->deleted();
    }
}
