<?php

namespace App\Repositories\Implementations;

use App\Http\Resources\Master\WfhPegawaiResource;
use App\Models\WfhPegawai;
use App\Repositories\Interfaces\WfhPegawaiRepositoryInterface;
use App\Traits\ResponseTrait;
use Dotenv\Exception\ValidationException;
use ErrorException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

class WfhPegawaiRepository implements WfhPegawaiRepositoryInterface
{

    use ResponseTrait;
    public function create(array $data)
    {
       $existingWfhPegawai = WfhPegawai::where('pegawai_id', $data['pegawai_id'])->first();

        if ($existingWfhPegawai) {
            return $this->alreadyExist('Wfh Pegawai Already Exist');
        }
        
        return $this->created(WfhPegawai::create($data));
    }

    public function get(Request $request)
    {
        try {
            $collection = WfhPegawai::with(['pegawai'])->latest();
            $keyword = $request->query("search");
            $isNotPaginate = $request->query("not-paginate");

            if ($keyword) {
                $collection->where('nama_pegawai', 'ILIKE', "%$keyword%");
            }

            if ($isNotPaginate) {
                $collection = $collection->get();
                $result = WfhPegawaiResource::collection($collection)->response()->getData(true);
                return $this->wrapResponse(Response::HTTP_OK, 'Successfully get Data', $result);
            } else {
                return $this->paginate2($collection, 'Successfully get Data', WfhPegawaiResource::class);
            }
        } catch (ValidationException $e) {
            return $this->wrapResponse(Response::HTTP_BAD_REQUEST, $e->getMessage());
        } catch (ErrorException $e) {
            return $this->wrapResponse(Response::HTTP_INTERNAL_SERVER_ERROR, 'Terjadi kesalahan internal.');
        } catch (\Throwable $th) {
            return $this->wrapResponse(Response::HTTP_INTERNAL_SERVER_ERROR, 'Terjadi kesalahan: ' . $th->getMessage());
        }
    }

    public function getById(string $id): ?WfhPegawai
    {
        return WfhPegawai::find($id);
    }

    public function update(string $id, array $data)
    {
        if (!Str::isUuid($id)) {
            return $this->invalidUUid();
        }

        $model = WfhPegawai::find($id);
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

        $model = WfhPegawai::find($id);
        if (!$model) {
            return $this->notFound();
        }

        $model->delete();
        return $this->deleted();
    }
}
