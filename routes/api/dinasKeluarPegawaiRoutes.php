<?php

use App\Http\Controllers\Master\DinasKeluarPegawaiController;


$router->group(['prefix' => 'master'], function () use ($router) {
  $router->group(['middleware' => 'auth:users'], function () use ($router) {
    $router->get('/dinas-keluar-pegawai', 'Master\DinasKeluarPegawaiController@index');
  });
  $router->group(['middleware' => 'auth:admin'], function () use ($router) {
    $router->post('/dinas-keluar-pegawai', 'Master\DinasKeluarPegawaiController@store');
    $router->put('/dinas-keluar-pegawai/{id}', 'Master\DinasKeluarPegawaiController@update');
    $router->delete('/dinas-keluar-pegawai/{id}', 'Master\DinasKeluarPegawaiController@destroy');
  });
});
