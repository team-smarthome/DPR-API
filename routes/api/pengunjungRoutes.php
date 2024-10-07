<?php

use App\Http\Controllers\Master\InstansiController;

$router->group(['prefix' => 'auth'], function () use ($router) {
  $router->get('/pengunjung', 'Master\PengunjungController@index');
  $router->post('/pengunjung', 'Master\PengunjungController@store');
  $router->put('/pengunjung/{id}', 'Master\PengunjungController@update');
  $router->delete('/pengunjung/{id}', 'Master\PengunjungController@delete');
});
