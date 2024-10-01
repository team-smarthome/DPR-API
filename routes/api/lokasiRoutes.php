<?php



$router->group(['prefix' => 'master'], function () use ($router) {
  $router->group(['middleware' => 'auth:user'], function () use ($router) {
    $router->get('/lokasi', 'Master\LokasiController@index');
  });
  $router->group(['middleware' => 'auth:super-admin'], function () use ($router) {
    $router->post('/lokasi', 'Master\LokasiController@store');
    $router->put('/lokasi/{id}', 'Master\LokasiController@update');
    $router->delete('/lokasi/{id}', 'Master\LokasiController@destroy');
  });
});
