<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Instansi;
use App\Repositories\Interfaces\InstansiRepositoryInterface;
use Illuminate\Http\Request;

class InstansiController extends Controller
{
  protected $instansiRepositoryInterface;

  public function __construct(InstansiRepositoryInterface $instansiRepositoryInterface)
  {
    $this->instansiRepositoryInterface = $instansiRepositoryInterface;
  }

  public function index(Request $request)
  {
    return $this->instansiRepositoryInterface->get($request);
  }
}
