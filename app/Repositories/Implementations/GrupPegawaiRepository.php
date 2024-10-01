<?php

namespace App\Repositories\Implementations;

use App\Http\Resources\Master\GrupPegawaiResource;
use App\Models\GrupPegawai;
use App\Repositories\Interfaces\GrupPegawaiRepositoryInterface;
use App\Traits\ResponseTrait;
use Dotenv\Exception\ValidationException;
use ErrorException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

class GrupPegawaiRepository implements GrupPegawaiRepositoryInterface
{   
    use ResponseTrait;
    public function create(array $data)
    {
        $existingGrupPegawai = GrupPegawai::where('nama_grup_pegawai', $data['nama_grup_pegawai'])->first();

        if ($existingGrupPegawai) {
            return $this->alreadyExist('Grup Pegawai Already Exist');
        }

        return $this->created(GrupPegawai::create($data));
    }

    public function get(Request $request)
    {
        try {
            $collection = GrupPegawai::latest();
            $keyword = $request->query("search");
            $isNotPaginate = $request->query("not-paginate");

            if ($keyword) {
                $collection->where('nama_grup_pegawai', 'ILIKE', "%$keyword%");
            }

            if ($isNotPaginate) {
                $collection = $collection->get();
                $result = GrupPegawaiResource::collection($collection)->response()->getData(true);
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

    public function getById(string $id): ?GrupPegawai
    {
        return GrupPegawai::find($id);
    }

    public function update(string $id, array $data)
    {
        if (!Str::isUuid($id)) {
        return $this->invalidUUid();
        }

        $model = GrupPegawai::find($id);
        if (!$model) {
            return $this->notFound();
        }

        $existingGrupPegawai = GrupPegawai::where('nama_grup_pegawai', $data['nama_grup_pegawai'])->first();
        if ($existingGrupPegawai) {
            return $this->alreadyExist('Grup Pegawai Already Exist');
        }

        $model->update($data);
        return $this->updated();
        
    }

    public function delete(string $id)
    {
        if (!Str::isUuid($id)) {
            return $this->invalidUUid();
        }  

        $model = GrupPegawai::find($id);
        if (!$model) {
            return $this->notFound();
        }

        $model->delete();
        return $this->deleted();
    }
}
