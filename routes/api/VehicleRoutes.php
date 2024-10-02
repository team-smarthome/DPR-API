<?php

use App\Http\Controllers\Master\VehicleController;


$router->group(['prefix' => 'master'], function () use ($router) {
    $router->group(['middleware' => 'auth:users'], function () use ($router) {
        $router->get('/vehicle', 'Master\VehicleController@index');

    });
    $router->group(['middleware' => 'auth:admin'], function () use ($router) {
        $router->post('/vehicle', 'Master\VehicleController@store');
        $router->put('/vehicle/{id}', 'Master\VehicleController@update');
        $router->delete('/vehicle/{id}', 'Master\VehicleController@destroy');
    });
});



