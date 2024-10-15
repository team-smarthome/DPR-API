<?php

namespace App\Repositories\Implementations;

use App\Http\Resources\Master\GrupVehiclePegawaiResource;
use App\Models\GrupVehiclePegawai;
use App\Repositories\Interfaces\GrupVehiclePegawaiRepositoryInterface;
use App\Traits\ResponseTrait;
use Dotenv\Exception\ValidationException;
use ErrorException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

class GrupVehiclePegawaiRepository implements GrupVehiclePegawaiRepositoryInterface
{
    use ResponseTrait;
    public function create(array $data)
    {
        $existingGrupVehiclePegawai = GrupVehiclePegawai::where('nama_grup_vehicle_pegawai', $data['nama_grup_vehicle_pegawai'])->first();

        if ($existingGrupVehiclePegawai) {
            return $this->alreadyExist('Grup Vehicle Pegawai Already Exist');
        }

        return $this->created(GrupVehiclePegawai::create($data));
    }

    public function get(Request $request)
    {
        try {
            $collection = GrupVehiclePegawai::latest();
            $keyword = $request->query("search");
            $isNotPaginate = $request->query("not-paginate");

            if ($keyword) {
                $collection->where('nama_grup_vehicle_pegawai', 'ILIKE', "%$keyword%");
            }

            if ($isNotPaginate) {
                $collection = $collection->get();
                $result = GrupVehiclePegawaiResource::collection($collection)->response()->getData(true);
                return $this->wrapResponse(Response::HTTP_OK, 'Successfully get Data', $result);
            } else {
                                return $this->paginate2($collection, 'Successfully get Data', GrupVehiclePegawaiResource::class);
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
        return GrupVehiclePegawai::find($id);
    }

    public function update(string $id, array $data)
    {
        if (!Str::isUuid($id)) {
            return $this->notFound('Grup Vehicle Pegawai Not Found');
        }

        $model = GrupVehiclePegawai::find($id);
        if (!$model) {
            return $this->notFound('Grup Vehicle Pegawai Not Found');
        }

        $existingGrupVehiclePegawai = GrupVehiclePegawai::where('nama_grup_vehicle_pegawai', $data['nama_grup_vehicle_pegawai'])->first();
        if ($existingGrupVehiclePegawai && $existingGrupVehiclePegawai->id !== $id) {
            return $this->alreadyExist('Grup Vehicle Pegawai Already Exist');
        }

        $model->update($data);
        return $this->updated($model);
    }

    public function delete(string $id): bool
    {
        $model = GrupVehiclePegawai::find($id);
        if (!$model) {
            return $this->notFound('Grup Vehicle Pegawai Not Found');
        }

        $model->delete();
        return $this->deleted();
    }
}
