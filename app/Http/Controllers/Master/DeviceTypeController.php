<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\DeviceTypeRequest;
use App\Repositories\Interfaces\DeviceTypeRepositoryInterface;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use Illuminate\Validation\ValidationException;

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
        try {
            $deviceTypeRequest = new DeviceTypeRequest();
            $data = $deviceTypeRequest->validate($request);
            return $this->deviceTypeRepositoryInterface->create($data);
        } catch (ValidationException $e) {
            return $this->alreadyExist('Device Type Already Exist');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $deviceTypeRequest = new DeviceTypeRequest();
            $data = $deviceTypeRequest->validate($request);

            return $this->deviceTypeRepositoryInterface->update($id, $data);
        } catch (ValidationException $e) {
            return $this->alreadyExist('Device Type Already Exist');
        }
    }

    public function destroy($id)
    {
        return $this->deviceTypeRepositoryInterface->delete($id);
    }
}
