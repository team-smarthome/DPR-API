<?php

use App\Http\Controllers\Master\JabatanController;

$router->group(['prefix' => 'master'], function () use ($router) {
  $router->group(['middleware' => 'auth:user'], function () use ($router) {
    $router->get('/jabatan', 'Master\JabatanController@index');
  });
  $router->group(['middleware' => 'auth:super-admin'], function () use ($router) {
    $router->post('/jabatan', 'Master\JabatanController@store');
    $router->put('/jabatan/{id}', 'Master\JabatanController@update');
    $router->delete('/jabatan/{id}', 'Master\JabatanController@delete');
  });
});
