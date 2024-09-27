<?php

namespace App\Http\Controllers\Master;

use App\Models\Jabatan;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Http\Requests\Master\JabatanRequest;
use App\Repositories\Interfaces\JabatanRepositoryInterface;
use App\Http\Controllers\Controller;

class JabatanController extends Controller
{
    use ResponseTrait;

    protected $jabatanRepositoryInterface;

    public function __construct(JabatanRepositoryInterface $jabatanRepositoryInterface)
    {
        $this->jabatanRepositoryInterface = $jabatanRepositoryInterface;
    }

    public function index(Request $request)
    {
        return $this->jabatanRepositoryInterface->get($request);
    }

    public function store(Request $request)
    {
        $jabatanRequest = new JabatanRequest();
        $data = $jabatanRequest->validate($request);
        
        return $this->jabatanRepositoryInterface->create($data);
        // return $this->created($jabatan);
    }

    public function update(Request $request, $id)
    {
    $jabatanRequest = new JabatanRequest();
    $data = $jabatanRequest->validate($request);

    $instansi = $this->jabatanRepositoryInterface->getById($id);

    if ($instansi == false) {
      return $this->notFound();
    }

    $this->jabatanRepositoryInterface->update($id, $data);

    return $this->updated();
    
    }

    public function delete($id){
    $jabatan = $this->jabatanRepositoryInterface->getById($id);

    if ($jabatan == false) {
      return $this->notFound();
    }

    $this->jabatanRepositoryInterface->delete($id);

    return $this->deleted();
  }
}
