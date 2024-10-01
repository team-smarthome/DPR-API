<?php

use App\Http\Controllers\Master\InstansiController;

// $router->get('/instansi', [InstansiController::class, 'index']);
$router->group(['prefix' => 'master'], function () use ($router) {
  $router->group(['middleware' => 'auth:user'], function () use ($router) {
    $router->get('/instansi', 'Master\InstansiController@@index');
  });
  $router->group(['middleware' => 'auth:super-admin'], function () use ($router) {
    $router->post('/instansi', 'Master\InstansiController@@store');
    $router->put('/instansi/{id}', 'Master\InstansiController@@update');
    $router->delete('/instansi/{id}', 'Master\InstansiController@@destroy');
  });
});
