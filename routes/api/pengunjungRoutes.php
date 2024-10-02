<?php

use App\Http\Controllers\Master\InstansiController;

$router->group(['prefix' => 'master'], function () use ($router) {
  $router->group(['middleware' => 'auth:user'], function () use ($router) {
    $router->get('/pengunjung', 'Master\PengunjungController@index');
  });
  $router->group(['middleware' => 'auth:super-admin'], function () use ($router) {
    $router->post('/pengunjung', 'Master\PengunjungController@store');
    $router->put('/pengunjung/{id}', 'Master\PengunjungController@update');
    $router->delete('/pengunjung/{id}', 'Master\PengunjungController@destroy');
  });
});
