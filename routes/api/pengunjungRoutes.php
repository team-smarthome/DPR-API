<?php

use App\Http\Controllers\Master\InstansiController;

$router->group(['prefix' => 'auth'], function () use ($router) {
  $router->post('/pengunjung', 'Master\PengunjungController@store');
});

$router->group(['prefix' => 'master'], function () use ($router) {
  $router->get('/pengunjung', 'Master\PengunjungController@index');
  $router->put('/pengunjung/{id}', 'Master\PengunjungController@update');
  $router->delete('/pengunjung/{id}', 'Master\PengunjungController@delete');
});
