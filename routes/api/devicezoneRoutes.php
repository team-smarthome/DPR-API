<?php

use App\Http\Controllers\Master\DeviceZoneController;

$router->get('/device-zone', 'Master\DeviceZoneController@index');
$router->post('/device-zone', 'Master\DeviceZoneController@store');
$router->delete('/device-zone/{id}', 'Master\DeviceZoneController@delete');
$router->put('/device-zone/{id}', 'Master\DeviceZoneController@update'); 
 