<?php

namespace App\Repositories\Implementations;

use App\Http\Resources\Master\SmartLockerCompartmentResource;
use App\Models\SmartLockerCompartment;
use App\Repositories\Interfaces\SmartLockerCompartmentRepositoryInterface;
use App\Traits\ResponseTrait;
use Dotenv\Exception\ValidationException;
use ErrorException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

class SmartLockerCompartmentRepository implements SmartLockerCompartmentRepositoryInterface
{
  use ResponseTrait;

  public function create(array $data)
  {
    $existingPengunjung = SmartLockerCompartment::where('number', $data['number'])->first();

    if ($existingPengunjung) {
      return $this->alreadyExist('Smart Locker Already Exist');
    }

    if (isset($data['qr_image']) && $this->isBase64Image($data['qr_image'])) {
      $data['qr_image'] = $this->saveBase64Image($data['qr_image'], 'images/smartlocker_compartment');
    }

    return $this->created(SmartLockerCompartment::create($data));
  }



  public function get(Request $request)
  {
    try {
      $collection = SmartLockerCompartment::latest();
      $keyword = $request->query("search");
      $isNotPaginate = $request->query("not-paginate");

      if ($keyword) {
        $collection->where('number', 'ILIKE', "%$keyword%");
      }

      if ($isNotPaginate) {
        $collection = $collection->get();
        $result = SmartLockerCompartmentResource::collection($collection)->response()->getData(true);
        return $this->wrapResponse(Response::HTTP_OK, 'Successfully get Data', $result);
      } else {
        return $this->paginate2($collection, 'Successfully get Data', SmartLockerCompartmentResource::class);
      }
    } catch (ValidationException $e) {
      return $this->wrapResponse(Response::HTTP_BAD_REQUEST, $e->getMessage());
    } catch (ErrorException $e) {
      return $this->wrapResponse(Response::HTTP_INTERNAL_SERVER_ERROR, 'Terjadi kesalahan internal.');
    } catch (\Throwable $th) {
      return $this->wrapResponse(Response::HTTP_INTERNAL_SERVER_ERROR, 'Terjadi kesalahan: ' . $th->getMessage());
    }
  }

  public function getById(string $id): ?SmartLockerCompartment
  {
    return SmartLockerCompartment::find($id);
  }

  public function update(string $id, array $data)
  {
    if (!Str::isUuid($id)) {
      return $this->invalidUUid();
    }

    $model = SmartLockerCompartment::find($id);
    if (!$model) {
      return $this->notFound();
    }

    if (isset($data['qr_image']) && $this->isBase64Image($data['qr_image'])) {
      $data['qr_image'] = $this->saveBase64Image($data['qr_image'], 'images/smartlocker_compartment');
    }

    $model->update($data);
    return $this->updated();
  }


  public function delete(string $id)
  {
    if (!Str::isUuid($id)) {
      return $this->invalidUUid();
    }

    $model = SmartLockerCompartment::find($id);
    if (!$model) {
      return $this->notFound();
    } else {
      $model->delete();
      return $this->deleted();
    }
  }
}
