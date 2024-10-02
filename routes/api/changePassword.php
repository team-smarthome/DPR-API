<?php

$router->group(['prefix' => 'auth'], function () use ($router) {
  $router->group(['middleware' => 'auth:user'], function () use ($router) {
    $router->put('/change-password', 'Auth\AuthController@changePassword');
  });
});
