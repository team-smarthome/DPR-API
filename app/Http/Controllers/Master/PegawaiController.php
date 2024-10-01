<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\PegawaiRequest;
use App\Repositories\Interfaces\PegawaiRepositoryInterface;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use Illuminate\Validation\ValidationException;

class PegawaiController extends Controller
{
    use ResponseTrait;

    protected $pegawaiRepositoryInterface;

    public function __construct(PegawaiRepositoryInterface $pegawaiRepositoryInterface)
    {
        $this->pegawaiRepositoryInterface = $pegawaiRepositoryInterface;
    }

    public function index(Request $request)
    {
        return $this->pegawaiRepositoryInterface->get($request);
    }


    public function store(Request $request)
    {
        try {
            $pegawaiRequest = new PegawaiRequest();
            $data = $pegawaiRequest->validate($request);
            return $this->pegawaiRepositoryInterface->create($data);
        } catch (ValidationException $e) {
            return $this->alreadyExist($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $pegawaiRequest = new PegawaiRequest();
            $data = $pegawaiRequest->validate($request);

            return $this->pegawaiRepositoryInterface->update($id, $data);
        } catch (ValidationException $e) {
            return $this->alreadyExist($e->getMessage());
        }
    }

    public function destroy($id)
    {
        return $this->pegawaiRepositoryInterface->delete($id);
    }

    public function getMe(Request $request)
    {
        return $this->pegawaiRepositoryInterface->getMe($request);
    }
}
