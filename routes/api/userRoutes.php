<?php

use App\Http\Controllers\Master\PegawaiController;


$router->group(['prefix' => 'master'], function () use ($router) {
  $router->group(['middleware' => 'auth:users'], function () use ($router) {
    $router->get('/users', 'Master\UserController@index');
    $router->post('/users', 'Master\UserController@store');
    $router->delete('/users/{id}', 'Master\UserController@destroy');
    $router->put('/users/set-role/{id}', 'Master\UserController@updateRoleId');
    $router->put('/users/reset-password/{id}', 'Master\UserController@resetPassword');
  });
});
