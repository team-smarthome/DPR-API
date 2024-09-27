<?php

namespace App\Repositories\Implementations;

use App\Http\Resources\JabatanResource;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use App\Repositories\Interfaces\JabatanRepositoryInterface;
use App\Traits\ResponseTrait;

use Symfony\Component\HttpFoundation\Response;

class JabatanRepository implements JabatanRepositoryInterface
{
    use ResponseTrait;
    public function create(array $data)
    {
        $existingJabatan = Jabatan::where('nama_jabatan', $data['nama_jabatan'])->first();
        
        if ($existingJabatan) {
            return $this->alreadyExist('Jabatan Already Exist');
        }
    
            return Jabatan::create($data);
    }

    public function get(Request $request)
  {
      try {
          $collection = Jabatan::with('instansi')->latest();
          $keyword = $request->query("search");
          $isNotPaginate = $request->query("not-paginate");

          if ($keyword) {
              $collection->where('nama_jabatan', 'ILIKE', "%$keyword%");
          }

          if ($isNotPaginate) {
              $collection = $collection->get();
              $result = JabatanResource::collection($collection)->response()->getData(true);
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

    public function getById(string $id): ?Jabatan
    {
        return Jabatan::find($id);
    }

    public function update(string $id, array $data): ?Jabatan
    {
        $model = Jabatan::find($id);
        if ($model) {
            $model->update($data);
            return $model;
        }
        return null;
    }

    public function delete(string $id): bool
    {
        $model = Jabatan::find($id);
        if (!$model) {
            return false;
          } else {
            return $model->delete();
          }
    }
}
