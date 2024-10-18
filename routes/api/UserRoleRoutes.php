<?php

$router->group(['prefix' => 'master'], function () use ($router) {

  $router->get('/user-role', 'Master\UserRoleController@index');
  $router->post('/user-role', 'Master\UserRoleController@store');
  $router->put('/user-role/{id}', 'Master\UserRoleController@reschedule');
  $router->delete('/user-role/{id}', 'Master\UserRoleController@destroy');
});
