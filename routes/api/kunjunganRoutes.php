<?php



$router->group(['prefix' => 'master'], function () use ($router) {

  $router->get('/kunjungan', 'Master\KunjunganController@index');
  $router->post('/kunjungan', 'Master\KunjunganController@store');
  $router->put('/kunjungan/reschedule/{id}', 'Master\KunjunganController@reschedule');
  $router->delete('/kunjungan/{id}', 'Master\KunjunganController@destroy');

  $router->group(['middleware' => 'auth:admin'], function () use ($router) {
    $router->put('/kunjungan/{id}', 'Master\KunjunganController@update');
  });
});
