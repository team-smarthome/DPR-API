<?php

use App\Http\Controllers\Master\PegawaiController;


$router->post('auth/pegawai', 'Master\PegawaiController@store');
$router->group(['prefix' => 'master'], function () use ($router) {
  $router->group(['middleware' => 'auth:users'], function () use ($router) {
    $router->get('/pegawai', 'Master\PegawaiController@index');
    $router->get('/getMe', 'Master\PegawaiController@getMe');
  });
  $router->group(['middleware' => 'auth:admin'], function () use ($router) {
    $router->put('/pegawai/{id}', 'Master\PegawaiController@update');
    $router->delete('/pegawai/{id}', 'Master\PegawaiController@destroy');
  });
});

$router->group(['prefix' => 'auth'], function () use ($router) {
  $router->group(['middleware' => 'auth:users'], function () use ($router) {
    $router->get('/getMe', 'Master\PegawaiController@getMe');
  });
});
