<?php

use App\Http\Controllers\Master\JabatanController;

$router->group(['prefix' => 'master'], function () use ($router) {
  $router->group(['middleware' => 'auth:user'], function () use ($router) {
    $router->get('/jabatan', 'Master\GrupPegawaiController@index');
  });
  $router->group(['middleware' => 'auth:super-admin'], function () use ($router) {
    $router->post('/jabatan', 'Master\GrupPegawaiController@store');
    $router->put('/jabatan/{id}', 'Master\GrupPegawaiController@update');
    $router->delete('/jabatan/{id}', 'Master\GrupPegawaiController@destroy');
  });
});
