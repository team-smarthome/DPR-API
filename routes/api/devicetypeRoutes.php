<?php

use App\Http\Controllers\Master\DeviceTypeController;
// $router->group(['middleware' => 'auth'], function () use ($router) {
//         $router->get('/device-type', 'Master\DeviceTypeController@index');
// });

$router->group(['prefix' => 'master'], function () use ($router) {
  $router->group(['middleware' => 'auth:user'], function () use ($router) {
    $router->get('/device-type', 'Master\GrupPegawaiController@index');
  });
  $router->group(['middleware' => 'auth:super-admin'], function () use ($router) {
    $router->post('/device-type', 'Master\GrupPegawaiController@store');
    $router->put('/device-type/{id}', 'Master\GrupPegawaiController@update');
    $router->delete('/device-type/{id}', 'Master\GrupPegawaiController@destroy');
  });
});