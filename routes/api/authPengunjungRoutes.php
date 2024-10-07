<?php
$router->group(['prefix' => 'auth'], function () use ($router) {
  $router->post('/login-pengunjung', 'Auth\LoginPengunjungController@login');
});
