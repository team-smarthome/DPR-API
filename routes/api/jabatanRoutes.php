<?php

use App\Http\Controllers\Master\JabatanController;

$router->get('/jabatan', 'Master\JabatanController@index');
$router->post('/jabatan', 'Master\JabatanController@store');
$router->delete('/jabatan/{id}', 'Master\JabatanController@delete');
$router->put('/jabatan/{id}', 'Master\JabatanController@update'); 
