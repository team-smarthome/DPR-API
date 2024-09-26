<?php

use App\Http\Controllers\Master\InstansiController;

$router->get('/instansi', [InstansiController::class, 'index']);
