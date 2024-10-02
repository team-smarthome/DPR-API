<?php

namespace App\Repositories\Implementations;

use App\Models\Zona;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Http\Resources\Master\ZonaResource;
use Symfony\Component\HttpFoundation\Response;
use App\Repositories\Interfaces\ZonaRepositoryInterface;

class ZonaRepository implements ZonaRepositoryInterface
{
    use ResponseTrait;

    public function create($data)
    {
        $resource =  Zona::create($data);

        if($resource){
            return $this->created($resource);
        }
    }

    public function get(Request $request)
    {
        try {
                $collection = Zona::with(['recursiveParents'])
                ->whereNull('parent_id')
                ->latest();

                $keyword = $request->query("search");
                $isNotPaginate = $request->query("not-paginate");

                if ($keyword) {
                    $collection->where('nama_zona', 'ILIKE', "%$keyword%");
                }

                if ($isNotPaginate) {
                    $collection = $collection->get();
                    $result = ZonaResource::collection($collection)->response()->getData(true);
                    return $this->wrapResponse(Response::HTTP_OK, 'Successfully get Data', $result);
                } else {
                    // $result = ZonaResource::collection($collection)->response()->getData(true);
                    return $this->paginate2($collection, 'Successfully get Data', ZonaResource::class);
                    // return $this->paginate($collection, null, 'Successfully get Data');
                }

        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function getById(string $id): ?Zona
    {
        return Zona::find($id);
    }

    public function update(string $id, array $data): ?Zona
    {
        $model = Zona::find($id);
        if ($model) {
            $model->update($data);
            return $model;
        }
        return null;
    }

    public function delete(string $id): bool
    {
        $model = Zona::find($id);
        return $model ? $model->delete() : false;
    }
}
