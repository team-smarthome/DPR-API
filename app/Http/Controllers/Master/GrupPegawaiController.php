<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\GrupPegawaiRequest;
use App\Repositories\Interfaces\GrupPegawaiRepositoryInterface;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use Illuminate\Validation\ValidationException;


class GrupPegawaiController extends Controller
{
    use ResponseTrait;

    protected $grupPegawaiRepositoryInterface;

    public function __construct(GrupPegawaiRepositoryInterface $grupPegawaiRepositoryInterface)
    {
        $this->grupPegawaiRepositoryInterface = $grupPegawaiRepositoryInterface;
    }

    public function index(Request $request)
    {
        return $this->grupPegawaiRepositoryInterface->get($request);
    }

    public function store(Request $request)
    {
        try {
            $grupPegawaiRequest = new GrupPegawaiRequest();
            $data = $grupPegawaiRequest->validate($request);
            return $this->grupPegawaiRepositoryInterface->create($data);
        } catch (ValidationException $e) {
            return $this->alreadyExist('Grup Pegawai Already Exist');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $grupPegawaiRequest = new GrupPegawaiRequest();
            $data = $grupPegawaiRequest->validate($request);

            return $this->grupPegawaiRepositoryInterface->update($id, $data);
        } catch (ValidationException $e) {
            return $this->alreadyExist('Grup Pegawai Already Exist');
        }
    }

    public function destroy($id)
    {
        return $this->grupPegawaiRepositoryInterface->delete($id);
    }
}
