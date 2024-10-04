<?php

namespace App\Repositories\Implementations;

use App\Http\Resources\Master\PegawaiResource;
use App\Models\Pegawai;
use App\Repositories\Interfaces\PegawaiRepositoryInterface;
use App\Traits\ResponseTrait;
use Dotenv\Exception\ValidationException;
use ErrorException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

class PegawaiRepository implements PegawaiRepositoryInterface
{
    use ResponseTrait;
    public function create(array $data)
    {
        $existingPegawai = Pegawai::where('nip', $data['nip'])->first();

        if ($existingPegawai) {
            return $this->alreadyExist('Pegawai Already Exist');
        }
        
        return $this->created(Pegawai::create($data));
    }

    public function get(Request $request)
    {
        try {
            $collection = Pegawai::with(['jabatan.instansi', 'palmData', 'facialData', 'grupPegawai'])->latest();
            $keyword = $request->query("search");
            $isNotPaginate = $request->query("not-paginate");

            if ($keyword) {
                $collection->where('nama_pegawai', 'ILIKE', "%$keyword%");
            }

            if ($isNotPaginate) {
                $collection = $collection->get();
                $result = PegawaiResource::collection($collection)->response()->getData(true);
                return $this->wrapResponse(Response::HTTP_OK, 'Successfully get Data', $result);
            } else {
                return $this->paginate2($collection, 'Successfully get Data', PegawaiResource::class);
            }
        } catch (ValidationException $e) {
            return $this->wrapResponse(Response::HTTP_BAD_REQUEST, $e->getMessage());
        } catch (ErrorException $e) {
            return $this->wrapResponse(Response::HTTP_INTERNAL_SERVER_ERROR, 'Terjadi kesalahan internal.');
        } catch (\Throwable $th) {
            return $this->wrapResponse(Response::HTTP_INTERNAL_SERVER_ERROR, 'Terjadi kesalahan: ' . $th->getMessage());
        }
    }

    public function getById(string $id): ?Pegawai
    {
        return Pegawai::find($id);
    }

    public function update(string $id, array $data)
    {   
        if (!Str::isUuid($id)) {
            return $this->invalidUUid();
        }

        $model = Pegawai::find($id);
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

        $model = Pegawai::find($id);
        if (!$model) {
            return $this->notFound();
        }

        $model->delete();
        return $this->deleted();
    }

   public function getMe(Request $request)
    {
        $userId = $request->user_id;
        $pegawai = Pegawai::with(['jabatan.instansi', 'palmData', 'facialData', 'grupPegawai'])
            ->where('id', $userId)
            ->first(); 

        if ($pegawai) {
            $roleId =  $request->role_id; 
            $roleName = $request->nama_role; 
            
            $pegawaiResource = new PegawaiResource($pegawai, $userId, $roleId, $roleName);
            $result = $pegawaiResource->toArray($request); 

            return $this->wrapResponse2(Response::HTTP_OK, 'Successfully get Data', $result);
        }
        return $this->wrapResponse2(Response::HTTP_NOT_FOUND, 'Data not found');
    }





}
