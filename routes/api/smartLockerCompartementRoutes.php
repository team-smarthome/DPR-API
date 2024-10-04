<?php



$router->group(['prefix' => 'master'], function () use ($router) {
  $router->group(['middleware' => 'auth:users'], function () use ($router) {
    $router->get('/smartlocker-compartment', 'Master\SmartLockerCompartmentController@index');
  });
  $router->group(['middleware' => 'auth:admin'], function () use ($router) {
    $router->post('/smartlocker-compartment', 'Master\SmartLockerCompartmentController@store');
    $router->put('/smartlocker-compartment/{id}', 'Master\SmartLockerCompartmentController@update');
    $router->delete('/smartlocker-compartment/{id}', 'Master\SmartLockerCompartmentController@destroy');
  });
});
