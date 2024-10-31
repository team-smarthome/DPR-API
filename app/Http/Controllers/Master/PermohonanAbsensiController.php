<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\PermohonanAbsensi;
use App\Repositories\Interfaces\PermohonanAbsensiRepositoryInterface;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class PermohonanAbsensiController extends Controller
{
  use ResponseTrait;
  protected $permohonanAbsensiRepositoryInterface;
  public function __construct(PermohonanAbsensiRepositoryInterface $permohonanAbsensiRepositoryInterface)
  {
    $this->permohonanAbsensiRepositoryInterface = $permohonanAbsensiRepositoryInterface;
  }
  public function index(Request $request)
  {
    return $this->permohonanAbsensiRepositoryInterface->get($request);
  }

  public function show($id)
  {
    return PermohonanAbsensi::find($id);
  }

  public function store(Request $request)
  {
    return $this->permohonanAbsensiRepositoryInterface->create($request->all());
  }

  public function update(Request $request, $id)
  {
    return $this->permohonanAbsensiRepositoryInterface->update($id, $request->all());
  }

  public function destroy($id)
  {
    return $this->permohonanAbsensiRepositoryInterface->delete($id);
  }
}
