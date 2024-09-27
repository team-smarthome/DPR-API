<?php

namespace App\Http\Controllers\Master;

use App\Models\DeviceType;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Master\DeviceTypeRequest;
use App\Repositories\Interfaces\DeviceTypeRepositoryInterface;

class DeviceTypeController extends Controller
{
    use ResponseTrait;

    protected $deviceTypeRepositoryInterface;

    public function __construct(DeviceTypeRepositoryInterface $deviceTypeRepositoryInterface)
    {
        $this->deviceTypeRepositoryInterface = $deviceTypeRepositoryInterface;
    }

    public function index(Request $request)
    {
        return $this->deviceTypeRepositoryInterface->get($request);
    }

    public function store(Request $request)
    {
        $deviceTypeRequest = new DeviceTypeRequest();
        $data = $deviceTypeRequest->validate($request);
        
        return $this->deviceTypeRepositoryInterface->create($data);
    }

    public function update(Request $request, $id)
    {
        $deviceTypeRequest = new DeviceTypeRequest();
        $data = $deviceTypeRequest->validate($request);

        $deviceType = $this->deviceTypeRepositoryInterface->getById($id);

        if ($deviceType == false) {
        return $this->notFound();
        }

        $this->deviceTypeRepositoryInterface->update($id, $data);

        return $this->updated();
    }

    public function delete($id)
    {
        $deviceType = $this->deviceTypeRepositoryInterface->getById($id);

        if ($deviceType == false) {
            return $this->notFound();
          }
      
          $this->deviceTypeRepositoryInterface->delete($id);
      
          return $this->deleted();
    }
}
