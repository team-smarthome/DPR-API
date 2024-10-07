<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\GrupVehiclePegawaiRequest;
use App\Repositories\Interfaces\GrupVehiclePegawaiRepositoryInterface;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use Illuminate\Validation\ValidationException;

class GrupVehiclePegawaiController extends Controller
{
    use ResponseTrait;

    protected $grupVehiclePegawaiRepositoryInterface;

    public function __construct(GrupVehiclePegawaiRepositoryInterface $grupVehiclePegawaiRepositoryInterface)
    {
        $this->grupVehiclePegawaiRepositoryInterface = $grupVehiclePegawaiRepositoryInterface;
    }

    public function index(Request $request)
    {
        return $this->grupVehiclePegawaiRepositoryInterface->get($request);
    }


    public function store(Request $request)
    {
        try {
            $grupVehiclePegawaiRequest = new GrupVehiclePegawaiRequest();
            $data = $grupVehiclePegawaiRequest->validate($request);
            return $this->grupVehiclePegawaiRepositoryInterface->create($data);
        } catch (ValidationException $e) {
            return $this->alreadyExist('Grup Vehicle Pegawai Already Exist');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $grupVehiclePegawaiRequest = new GrupVehiclePegawaiRequest();
            $data = $grupVehiclePegawaiRequest->validate($request);

            return $this->grupVehiclePegawaiRepositoryInterface->update($id, $data);
        } catch (ValidationException $e) {
            return $this->alreadyExist('Grup Vehicle Pegawai Already Exist');
        }
    }

    public function destroy($id)
    {
        return $this->grupVehiclePegawaiRepositoryInterface->delete($id);
    }
}
