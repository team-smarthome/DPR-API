<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Implementations\DeviceRepository;
use App\Repositories\Implementations\JabatanRepository;
use App\Repositories\Implementations\InstansiRepository;
use App\Repositories\Implementations\DeviceTypeRepository;
use App\Repositories\Implementations\DeviceZoneRepository;
use App\Repositories\Interfaces\DeviceRepositoryInterface;
use App\Repositories\Interfaces\JabatanRepositoryInterface;
use App\Repositories\Interfaces\InstansiRepositoryInterface;
use App\Repositories\Interfaces\DeviceTypeRepositoryInterface;
use App\Repositories\Interfaces\DeviceZoneRepositoryInterface;
use App\Repositories\Implementations\LokasiRepository;
use App\Repositories\Implementations\ZonaRepository;
use App\Repositories\Interfaces\LokasiRepositoryInterface;
use App\Repositories\Interfaces\ZonaRepositoryInterface;
use App\Repositories\Interfaces\AuthRepositoryInterface;
use App\Repositories\Implementations\AuthRepository;
use App\Repositories\Implementations\GrupPegawaiRepository;
use App\Repositories\Implementations\KunjunganRepository;
use App\Repositories\Interfaces\GrupPegawaiRepositoryInterface;
use App\Repositories\Implementations\PegawaiRepository;
use App\Repositories\Implementations\PengunjungRepository;
use App\Repositories\Interfaces\PegawaiRepositoryInterface;
use App\Repositories\Implementations\WfhPegawaiRepository;
use App\Repositories\Interfaces\KunjunganRepositoryInterface;
use App\Repositories\Interfaces\PengunjungRepositoryInterface;
use App\Repositories\Interfaces\WfhPegawaiRepositoryInterface;
use App\Repositories\Implementations\AbsensiPegawaiRepository;
use App\Repositories\Implementations\FacialDataRepository;
use App\Repositories\Interfaces\AbsensiPegawaiRepositoryInterface;
use App\Repositories\Implementations\VehicleRepository;
use App\Repositories\Interfaces\FacialDataRepositoryInterface;
use App\Repositories\Interfaces\VehicleRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   *
   * @return void
   */
  public function register()
  {
    $this->app->bind(DeviceZoneRepositoryInterface::class, DeviceZoneRepository::class);
    $this->app->bind(DeviceRepositoryInterface::class, DeviceRepository::class);
    $this->app->bind(DeviceTypeRepositoryInterface::class, DeviceTypeRepository::class);
    $this->app->bind(JabatanRepositoryInterface::class, JabatanRepository::class);
    $this->app->bind(InstansiRepositoryInterface::class, InstansiRepository::class);
    $this->app->bind(ZonaRepositoryInterface::class, ZonaRepository::class);
    $this->app->bind(LokasiRepositoryInterface::class, LokasiRepository::class);
    $this->app->bind(AuthRepositoryInterface::class, AuthRepository::class);
    $this->app->bind(GrupPegawaiRepositoryInterface::class, GrupPegawaiRepository::class);
    $this->app->bind(PegawaiRepositoryInterface::class, PegawaiRepository::class);
    $this->app->bind(WfhPegawaiRepositoryInterface::class, WfhPegawaiRepository::class);
    $this->app->bind(AbsensiPegawaiRepositoryInterface::class, AbsensiPegawaiRepository::class);
    $this->app->bind(VehicleRepositoryInterface::class, VehicleRepository::class);
    $this->app->bind(PengunjungRepositoryInterface::class, PengunjungRepository::class);
    $this->app->bind(KunjunganRepositoryInterface::class, KunjunganRepository::class);
    $this->app->bind(FacialDataRepositoryInterface::class, FacialDataRepository::class);
  }
}
