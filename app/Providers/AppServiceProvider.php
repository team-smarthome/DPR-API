<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Implementations\JabatanRepository;
use App\Repositories\Implementations\InstansiRepository;
use App\Repositories\Interfaces\JabatanRepositoryInterface;
use App\Repositories\Interfaces\InstansiRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   *
   * @return void
   */
  public function register()
  {
    $this->app->bind(JabatanRepositoryInterface::class, JabatanRepository::class);
    $this->app->bind(InstansiRepositoryInterface::class, InstansiRepository::class);
  }
}
