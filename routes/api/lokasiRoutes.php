<?php



$router->group(['prefix' => 'master'], function () use ($router) {
  $router->group(['middleware' => 'auth:user'], function () use ($router) {
    $router->get('/lokasi', 'Master\GrupPegawaiController@index');
  });
  $router->group(['middleware' => 'auth:super-admin'], function () use ($router) {
    $router->post('/lokasi', 'Master\GrupPegawaiController@store');
    $router->put('/lokasi/{id}', 'Master\GrupPegawaiController@update');
    $router->delete('/lokasi/{id}', 'Master\GrupPegawaiController@destroy');
  });
});
