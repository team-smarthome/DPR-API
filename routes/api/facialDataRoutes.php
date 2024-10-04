<?php



$router->group(['prefix' => 'master'], function () use ($router) {
  $router->group(['middleware' => 'auth:user'], function () use ($router) {
    $router->get('/facial-data', 'Master\FacialDataController@index');
  });
  $router->group(['middleware' => 'auth:super-admin'], function () use ($router) {
    $router->post('/facial-data', 'Master\FacialDataController@store');
    $router->put('/facial-data/{id}', 'Master\FacialDataController@update');
    $router->delete('/facial-data/{id}', 'Master\FacialDataController@destroy');
  });
});
