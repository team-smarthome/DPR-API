<?php

use App\Http\Controllers\Auth\AuthController;
$router->group(['prefix' => 'auth'], function () use ($router) {
    $router->post('/login', 'Auth\AuthController@login');
});


// $router->post('/login', 'Auth\AuthController@login');
// $router->group(['middleware' => 'session'], function () use ($router) {
//     $router->post('/login', 'Auth\AuthController@login');
// });

