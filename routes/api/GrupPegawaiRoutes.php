<?php

use App\Http\Controllers\Master\GrupPegawaiController;


$router->group(['prefix' => 'master'], function () use ($router) {
    $router->group(['middleware' => 'auth:user'], function () use ($router) {
        $router->get('/grup-pegawai', 'Master\GrupPegawaiController@index');
    });
    $router->group(['middleware' => 'auth:admin'], function () use ($router) {
        $router->post('/grup-pegawai', 'Master\GrupPegawaiController@store');
        $router->put('/grup-pegawai/{id}', 'Master\GrupPegawaiController@update');
        $router->delete('/grup-pegawai/{id}', 'Master\GrupPegawaiController@destroy');
    });
});


