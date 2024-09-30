<?php

use App\Http\Controllers\Master\DeviceTypeController;
// $router->group(['middleware' => 'auth'], function () use ($router) {
//         $router->get('/device-type', 'Master\DeviceTypeController@index');
// });

$router->group(['middleware' => 'auth:super-admin'], function () use ($router) {
    $router->get('/device-type', 'Master\DeviceTypeController@index');
});


// $router->get('/device-type', 'Master\DeviceTypeController@index');
$router->post('/device-type', 'Master\DeviceTypeController@store');
$router->delete('/device-type/{id}', 'Master\DeviceTypeController@delete');
$router->put('/device-type/{id}', 'Master\DeviceTypeController@update'); 
