<?php

use App\Http\Controllers\Master\DeviceZoneController;

$router->group(['prefix' => 'master'], function () use ($router) {
  $router->group(['middleware' => 'auth:user'], function () use ($router) {
    $router->get('/device-zona', 'Master\GrupPegawaiController@index');
  });
  $router->group(['middleware' => 'auth:super-admin'], function () use ($router) {
    $router->post('/device-zona', 'Master\GrupPegawaiController@store');
    $router->put('/device-zona/{id}', 'Master\GrupPegawaiController@update');
    $router->delete('/device-zona/{id}', 'Master\GrupPegawaiController@destroy');
  });
});
