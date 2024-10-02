<?php

use App\Http\Controllers\Master\AbsensiPegawaiController;


$router->group(['prefix' => 'master'], function () use ($router) {
    $router->group(['middleware' => 'auth:users'], function () use ($router) {
        $router->get('/absensi-pegawai', 'Master\AbsensiPegawaiController@index');

    });
    $router->group(['middleware' => 'auth:admin'], function () use ($router) {
        $router->post('/absensi-pegawai', 'Master\AbsensiPegawaiController@store');
        $router->put('/absensi-pegawai/{id}', 'Master\AbsensiPegawaiController@update');
        $router->delete('/absensi-pegawai/{id}', 'Master\AbsensiPegawaiController@destroy');
    });
});



