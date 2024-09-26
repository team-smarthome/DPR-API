<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\InstansiRequest;
use App\Repositories\Interfaces\InstansiRepositoryInterface;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;

class InstansiController extends Controller
{
    use ResponseTrait;

    protected $instansiRepositoryInterface;

    public function __construct(InstansiRepositoryInterface $instansiRepositoryInterface)
    {
        $this->instansiRepositoryInterface = $instansiRepositoryInterface;
    }

    public function index(Request $request)
    {
        return $this->instansiRepositoryInterface->get($request);
    }

    public function store(Request $request) 
    {
        $instansiRequest = new InstansiRequest();
        $data = $instansiRequest->validate($request);
        
        $instansi = $this->instansiRepositoryInterface->create($data);

        return $this->created($instansi);
    }
}
