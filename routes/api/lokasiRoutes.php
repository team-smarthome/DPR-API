<?php



$router->get('/lokasi', 'Master\LokasiController@index');
$router->post('/lokasi', 'Master\LokasiController@store');
$router->delete('/lokasi/{id}', 'Master\LokasiController@delete');
$router->put('/lokasi/{id}', 'Master\LokasiController@update');
