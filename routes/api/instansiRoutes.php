<?php

use App\Http\Controllers\Master\InstansiController;

// $router->get('/instansi', [InstansiController::class, 'index']);
$router->get('/instansi', 'Master\InstansiController@index');
$router->post('/instansi', 'Master\InstansiController@store');
$router->delete('/instansi/{id}', 'Master\InstansiController@delete');
