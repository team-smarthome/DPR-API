<?php



$router->group(['prefix' => 'master'], function () use ($router) {
  // $router->group(['middleware' => 'auth:user'], function () use ($router) {
  $router->get('/kunjungan', 'Master\KunjunganController@index');
  $router->post('/kunjungan', 'Master\KunjunganController@store');
  // });
  $router->group(['middleware' => 'auth:super-admin'], function () use ($router) {
    $router->put('/kunjungan/{id}', 'Master\KunjunganController@update');
    $router->delete('/kunjungan/{id}', 'Master\KunjunganController@destroy');
  });
});
