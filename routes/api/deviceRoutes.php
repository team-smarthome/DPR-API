<?php

use App\Http\Controllers\Master\DeviceController;

$router->group(['prefix' => 'master'], function () use ($router) {
  $router->group(['middleware' => 'auth:user'], function () use ($router) {
    $router->get('/device', 'Master\DeviceControlle@index');
  });
  $router->group(['middleware' => 'auth:super-admin'], function () use ($router) {
    $router->post('/device', 'Master\DeviceControlle@store');
    $router->put('/device/{id}', 'Master\DeviceControlle@update');
    $router->delete('/device/{id}', 'Master\DeviceControlle@destroy');
  });
});
