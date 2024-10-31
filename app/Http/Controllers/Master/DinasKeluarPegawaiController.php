<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\DinasKeluarPegawai;
use App\Repositories\Interfaces\DinasKeluarPegawaiRepositoryInterface;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class DinasKeluarPegawaiController extends Controller
{
  use ResponseTrait;
  protected $dinasKeluarPegawaiRepositoryInterface;
  public function __construct(DinasKeluarPegawaiRepositoryInterface $dinasKeluarPegawaiRepositoryInterface)
  {
    $this->dinasKeluarPegawaiRepositoryInterface = $dinasKeluarPegawaiRepositoryInterface;
  }
  public function index(Request $request)
  {
    return $this->dinasKeluarPegawaiRepositoryInterface->get($request);
  }

  public function show($id)
  {
    return DinasKeluarPegawai::find($id);
  }

  public function store(Request $request)
  {
    return $this->dinasKeluarPegawaiRepositoryInterface->create($request->all());
  }

  public function update(Request $request, $id)
  {
    return $this->dinasKeluarPegawaiRepositoryInterface->update($id, $request->all());
  }

  public function destroy($id)
  {
    return $this->dinasKeluarPegawaiRepositoryInterface->delete($id);
  }
}
