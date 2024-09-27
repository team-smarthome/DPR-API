<?php

use App\Http\Controllers\Master\DeviceController;

$router->get('/device', 'Master\DeviceController@index');
$router->post('/device', 'Master\DeviceController@store');
$router->delete('/device/{id}', 'Master\DeviceController@delete');
$router->put('/device/{id}', 'Master\DeviceController@update'); 
