<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\InstansiRepositoryInterface;
use App\Repositories\Implementations\InstansiRepository;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   *
   * @return void
   */
  public function register()
  {
    $this->app->bind(InstansiRepositoryInterface::class, InstansiRepository::class);
  }
}
