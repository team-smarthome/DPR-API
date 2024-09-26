<?php

$router->get('/testget', function () {
    return response()->json(['message' => 'Hello World!']);
});
