<?php

$router->get('/testusers', function () {
    return response()->json(['users' => ['User1', 'User2']]);
});

