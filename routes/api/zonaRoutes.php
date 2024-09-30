<?php



$router->get('/zona', 'Master\ZonaController@index');
$router->post('/zona', 'Master\ZonaController@store');
$router->put('/zona/{id}', 'Master\ZonaController@update');
$router->delete('/zona/{id}', 'Master\ZonaController@delete');
