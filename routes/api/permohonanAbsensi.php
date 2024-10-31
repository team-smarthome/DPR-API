<?php

use App\Http\Controllers\Master\PermohonanAbsensiController;


$router->group(['prefix' => 'master'], function () use ($router) {
  $router->group(['middleware' => 'auth:users'], function () use ($router) {
    $router->get('/permohonan-absensi', 'Master\PermohonanAbsensiController@index');
  });
  $router->group(['middleware' => 'auth:admin'], function () use ($router) {
    $router->post('/permohonan-absensi', 'Master\PermohonanAbsensiController@store');
    $router->put('/permohonan-absensi/{id}', 'Master\PermohonanAbsensiController@update');
    $router->delete('/permohonan-absensi/{id}', 'Master\PermohonanAbsensiController@destroy');
  });
});
