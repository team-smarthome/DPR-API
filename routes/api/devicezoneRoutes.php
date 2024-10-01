<?php

use App\Http\Controllers\Master\DeviceZoneController;

$router->group(['prefix' => 'master'], function () use ($router) {
  $router->group(['middleware' => 'auth:user'], function () use ($router) {
    $router->get('/device-zona', 'Master\DeviceZoneController@index');
  });
  $router->group(['middleware' => 'auth:super-admin'], function () use ($router) {
    $router->post('/device-zona', 'Master\DeviceZoneController@store');
    $router->put('/device-zona/{id}', 'Master\DeviceZoneController@update');
    $router->delete('/device-zona/{id}', 'Master\DeviceZoneController@destroy');
  });
});
