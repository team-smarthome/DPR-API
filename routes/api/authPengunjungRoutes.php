<?php
$router->group(['prefix' => 'auth'], function () use ($router) {
  $router->post('/login-pengunjung', 'Auth\AuthPengunjungController@login');
  $router->put('/change-password-pengunjung/{id}', 'Auth\AuthPengunjungController@changePassword');
});


$router->group(['prefix' => 'master'], function () use ($router) {
  $router->group(['middleware' => 'auth:admin'], function () use ($router) {
    $router->patch('/user-pengunjung/{id}/is-active', 'Auth\AuthPengunjungController@updateIsActive');
  });
});
