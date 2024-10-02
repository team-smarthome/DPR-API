<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\VehicleRequest;
use App\Repositories\Interfaces\VehicleRepositoryInterface;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use Illuminate\Validation\ValidationException;

class VehicleController extends Controller
{

    use ResponseTrait;

    protected $vehicleRepositoryInterface;

    public function __construct(VehicleRepositoryInterface $vehicleRepositoryInterface)
    {
        $this->vehicleRepositoryInterface = $vehicleRepositoryInterface;
    }
    public function index(Request $request)
    {
        return $this->vehicleRepositoryInterface->get($request);
    }


    public function store(Request $request)
    {
        try {
            $vehicleRequest = new VehicleRequest();
            $data = $vehicleRequest->validate($request);
            return $this->vehicleRepositoryInterface->create($data);
        } catch (ValidationException $e) {
            return $this->alreadyExist($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $vehicleRequest = new VehicleRequest();
            $data = $vehicleRequest->validate($request);

            return $this->vehicleRepositoryInterface->update($id, $data);
        } catch (ValidationException $e) {
            return $this->alreadyExist($e->getMessage());
        }
    }

    public function destroy($id)
    {
        return $this->vehicleRepositoryInterface->delete($id);
    }
}
