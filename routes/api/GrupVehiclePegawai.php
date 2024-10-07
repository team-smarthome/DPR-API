<?php

use App\Http\Controllers\Master\GrupVehiclePegawaiController;


$router->group(['prefix' => 'master'], function () use ($router) {
    // $router->group(['middleware' => 'auth:user'], function () use ($router) {
        $router->get('/grup-vehicle-pegawai', 'Master\GrupVehiclePegawaiController@index');
    // });
    // $router->group(['middleware' => 'auth:admin'], function () use ($router) {
        $router->post('/grup-vehicle-pegawai', 'Master\GrupVehiclePegawaiController@store');
        $router->put('/grup-vehicle-pegawai/{id}', 'Master\GrupVehiclePegawaiController@update');
        $router->delete('/grup-vehicle-pegawai/{id}', 'Master\GrupVehiclePegawaiController@destroy');
    // });
});


