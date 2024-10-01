<?php

use App\Http\Controllers\Master\DeviceTypeController;
// $router->group(['middleware' => 'auth'], function () use ($router) {
//         $router->get('/device-type', 'Master\DeviceTypeController@index');
// });

$router->group(['prefix' => 'master'], function () use ($router) {
  $router->group(['middleware' => 'auth:user'], function () use ($router) {
    $router->get('/device-type', 'Master\DeviceController@index');
  });
  $router->group(['middleware' => 'auth:super-admin'], function () use ($router) {
    $router->post('/device-type', 'Master\DeviceController@store');
    $router->put('/device-type/{id}', 'Master\DeviceController@update');
    $router->delete('/device-type/{id}', 'Master\DeviceController@destroy');
  });
});