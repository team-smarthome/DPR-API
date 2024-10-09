<?php
$router->group(['prefix' => 'auth'], function () use ($router) {
  $router->post('/login-pengunjung', 'Auth\AuthPengunjungController@login');
  $router->put('/change-password-pengunjung/{id}', 'Auth\AuthPengunjungController@changePassword');
});
