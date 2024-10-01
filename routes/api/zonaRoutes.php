<?php



$router->group(['prefix' => 'master'], function () use ($router) {
  $router->group(['middleware' => 'auth:user'], function () use ($router) {
    $router->get('/zona', 'Master\GrupPegawaiController@index');
  });
  $router->group(['middleware' => 'auth:super-admin'], function () use ($router) {
    $router->post('/zona', 'Master\GrupPegawaiController@store');
    $router->put('/zona/{id}', 'Master\GrupPegawaiController@update');
    $router->delete('/zona/{id}', 'Master\GrupPegawaiController@destroy');
  });
});
