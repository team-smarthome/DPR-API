<?php

use App\Http\Controllers\Master\InstansiController;

$router->group(['prefix' => 'master'], function () use ($router) {
  $router->group(['middleware' => 'auth:user'], function () use ($router) {
    $router->get('/instansi', 'Master\GrupPegawaiController@index');
  });
  $router->group(['middleware' => 'auth:super-admin'], function () use ($router) {
    $router->post('/instansi', 'Master\GrupPegawaiController@store');
    $router->put('/instansi/{id}', 'Master\GrupPegawaiController@update');
    $router->delete('/instansi/{id}', 'Master\GrupPegawaiController@destroy');
  });
});