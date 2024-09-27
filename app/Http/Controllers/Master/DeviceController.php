<?php

namespace App\Http\Controllers\Master;

use App\Models\Device;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Master\DeviceRequest;
use App\Repositories\Interfaces\DeviceRepositoryInterface;

class DeviceController extends Controller
{
    use ResponseTrait;
    
    protected $deviceRepositoryInterface;

    public function __construct(DeviceRepositoryInterface $deviceRepositoryInterface)
    {
        $this->deviceRepositoryInterface = $deviceRepositoryInterface;
    }

    public function index(Request $request)
    {
        return $this->deviceRepositoryInterface->get($request);
    }

    public function store(Request $request)
    {
        $deviceRequest = new DeviceRequest();
        $data = $deviceRequest->validate($request);
        
        return $this->deviceRepositoryInterface->create($data);
    }

    public function update(Request $request, $id)
    {
        $deviceRequest = new DeviceRequest();
        $data = $deviceRequest->validate($request);

        $device = $this->deviceRepositoryInterface->getById($id);

        if ($device == false) {
        return $this->notFound();
        }

        $this->deviceRepositoryInterface->update($id, $data);

        return $this->updated();
    }

    public function delete($id)
    {
        $device = $this->deviceRepositoryInterface->getById($id);

        if ($device == false) {
            return $this->notFound();
          }
      
          $this->deviceRepositoryInterface->delete($id);
      
          return $this->deleted();
    }
}
