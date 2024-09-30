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
  }
}
