<?php



$router->group(['prefix' => 'master'], function () use ($router) {
  $router->group(['middleware' => 'auth:user'], function () use ($router) {
    $router->get('/zona', 'Master\ZonaController@index');
  });
  $router->group(['middleware' => 'auth:admin'], function () use ($router) {
    $router->post('/zona', 'Master\ZonaController@store');
    $router->put('/zona/{id}', 'Master\ZonaController@update');
    $router->delete('/zona/{id}', 'Master\ZonaController@destroy');
  });
});
