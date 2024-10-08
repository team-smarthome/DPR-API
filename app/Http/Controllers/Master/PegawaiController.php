<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Master\FacialDataRequest;
use App\Http\Requests\Master\PegawaiRequest;
use Illuminate\Validation\ValidationException;
use App\Repositories\Interfaces\PegawaiRepositoryInterface;
use Illuminate\Support\Facades\Hash;

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
            $facialRequest = new FacialDataRequest();
            $pegawaiRequest = new PegawaiRequest();

            return $this->pegawaiRepositoryInterface->create(
                [
                    'facial_data' => $facialRequest->validate($request),
                    'pegawai' =>  $pegawaiRequest->validate($request),
                    'user' => [
                        'password' => Hash::make($request->input('password')),
                    ]
                ]
            );
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
