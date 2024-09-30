<?php

namespace App\Http\Controllers\Master;

use App\Models\DeviceZone;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Master\DeviceZoneRequest;
use App\Repositories\Implementations\DeviceZoneRepository;

class DeviceZoneController extends Controller
{
    use ResponseTrait;

    protected $deviceZoneRepositoryInterface;

    public function __construct(DeviceZoneRepository $deviceZoneRepositoryInterface){
        $this->deviceZoneRepositoryInterface = $deviceZoneRepositoryInterface;
    }

    public function index(Request $request)
    {
        return $this->deviceZoneRepositoryInterface->get($request);
    }
    
    public function store(Request $request)
    {
        $deviceZoneRequest = new DeviceZoneRequest();
        $data = $deviceZoneRequest->validate($request);
        return $this->deviceZoneRepositoryInterface->create($data);
    }

    public function update(Request $request, $id)
    {
        $deviceZoneRequest = new DeviceZoneRequest();
        $data = $deviceZoneRequest->validate($request);
        
        $deviceZone = $this->deviceZoneRepositoryInterface->getById($id);

        if ($deviceZone == false) {
        return $this->notFound();
        }

        $this->deviceZoneRepositoryInterface->update($id, $data);

        return $this->updated();
    }

    public function delete($id)
    {
        $device = $this->deviceZoneRepositoryInterface->getById($id);

        if ($device == false) {
            return $this->notFound();
          }
      
          $this->deviceZoneRepositoryInterface->delete($id);
      
          return $this->deleted();
    }
}
