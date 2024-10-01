<?php

use App\Http\Controllers\Master\DeviceController;

$router->group(['prefix' => 'master'], function () use ($router) {
  $router->group(['middleware' => 'auth:user'], function () use ($router) {
    $router->get('/device', 'Master\GrupPegawaiController@index');
  });
  $router->group(['middleware' => 'auth:super-admin'], function () use ($router) {
    $router->post('/device', 'Master\GrupPegawaiController@store');
    $router->put('/device/{id}', 'Master\GrupPegawaiController@update');
    $router->delete('/device/{id}', 'Master\GrupPegawaiController@destroy');
  });
});
