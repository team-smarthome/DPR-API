<?php

$router->group(['prefix' => 'master'], function () use ($router) {
  $router->group(['middleware' => 'auth:users'], function () use ($router) {
    $router->get('/user-pengunjung', 'Master\UserPengunjungController@index');
    $router->post('/user-pengunjung', 'Master\UserPengunjungController@store');
    $router->delete('/user-pengunjung/{id}', 'Master\UserPengunjungController@destroy');
    $router->put('/user-pengunjung/reset-password/{id}', 'Master\UserPengunjungController@resetPassword');
  });
});
