<?php

namespace App\Repositories\Implementations;

use App\Models\Device;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use Illuminate\Http\Response;
use App\Http\Resources\DeviceResource;
use App\Repositories\Interfaces\DeviceRepositoryInterface;
use Illuminate\Validation\ValidationException;

class DeviceRepository implements DeviceRepositoryInterface
{
  use ResponseTrait;
  // public function create(array $data)
  // {
  //   $existingDevice = Device::where('nama_device', $data['nama_device'])->first();

  //   if ($existingDevice) {
  //     return $this->alreadyExist('Device Already Exist');
  //   }

  //   return $this->created(Device::create($data));
  // }

  public function create(array $data)
  {
    try {
      $createdDevices = [];

      foreach ($data as $deviceData) {
        $existingDevice = Device::where('nama_device', $deviceData['nama_device'])->first();
        if ($existingDevice) {
          return $this->alreadyExist('Device Already Exist');
        }
        $createdDevices[] = Device::create($deviceData);
      }

      // Return the list of created devices
      return $this->created($createdDevices);
    } catch (\Exception $e) {
      return $this->wrapResponse(Response::HTTP_INTERNAL_SERVER_ERROR, 'Terjadi kesalahan saat membuat data.');
    }
  }

  public function get(Request $request)
  {
    try {
      $collection = Device::latest();
      $keyword = $request->query("search");
      $isNotPaginate = $request->query("not-paginate");

      if ($keyword) {
        $collection->where('nama_device', 'ILIKE', "%$keyword%");
      }

      if ($isNotPaginate) {
        $collection = $collection->get();
        $result = DeviceResource::collection($collection)->response()->getData(true);
        return $this->wrapResponse(Response::HTTP_OK, 'Successfully get Data', $result);
      } else {
        return $this->paginate2($collection, 'Successfully get Data', DeviceResource::class);
      }
    } catch (ValidationException $e) {
      return $this->wrapResponse(Response::HTTP_BAD_REQUEST, $e->getMessage());
    } catch (ErrorException $e) {
      return $this->wrapResponse(Response::HTTP_INTERNAL_SERVER_ERROR, 'Terjadi kesalahan internal.');
    } catch (\Throwable $th) {
      return $this->wrapResponse(Response::HTTP_INTERNAL_SERVER_ERROR, 'Terjadi kesalahan: ' . $th->getMessage());
    }
  }

  public function getById(string $id): ?Device
  {
    return Device::find($id);
  }

  public function update(string $id, array $data): ?Device
  {
    $model = Device::find($id);
    if ($model) {
      $model->update($data);
      return $model;
    }
    return null;
  }

  public function delete(string $id): bool
  {
    $model = Device::find($id);
    if (!$model) {
      return false;
    } else {
      return $model->delete();
    }
  }
}
