<?php

use App\Http\Controllers\Master\WfhPegawaiController;


$router->group(['prefix' => 'master'], function () use ($router) {
    $router->group(['middleware' => 'auth:users'], function () use ($router) {
        $router->get('/wfh-pegawai', 'Master\WfhPegawaiController@index');

    });
    $router->group(['middleware' => 'auth:admin'], function () use ($router) {
        $router->post('/wfh-pegawai', 'Master\WfhPegawaiController@store');
        $router->put('/wfh-pegawai/{id}', 'Master\WfhPegawaiController@update');
        $router->delete('/wfh-pegawai/{id}', 'Master\WfhPeagawaiController@destroy');
    });
});



