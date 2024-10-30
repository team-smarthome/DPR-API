<?php



$router->group(['prefix' => 'master'], function () use ($router) {
  $router->group(['middleware' => 'auth:user'], function () use ($router) {
    $router->get('/lembur-pegawai', 'Master\LemburPegawaiController@index');
  });
  $router->group(['middleware' => 'auth:super-admin'], function () use ($router) {
    $router->post('/lembur-pegawai', 'Master\LemburPegawaiController@store');
    $router->put('/lembur-pegawai/{id}', 'Master\LemburPegawaiController@update');
    $router->delete('/lembur-pegawai/{id}', 'Master\LemburPegawaiController@destroy');
  });
});
