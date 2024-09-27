<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\InstansiRepositoryInterface;
use App\Repositories\Implementations\InstansiRepository;
use App\Repositories\Interfaces\AuthRepositoryInterface;
use App\Repositories\Implementations\AuthRepository;

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
    $this->app->bind(AuthRepositoryInterface::class, AuthRepository::class);
    
  }
}
