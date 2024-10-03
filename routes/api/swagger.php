<?php
$router->get('/api-docs', function () {
    $path = storage_path('api-docs/api-docs.json');

    if (!file_exists($path)) {
        return response()->json(['message' => 'File not found'], 404);
    }

    $json = file_get_contents($path);
    return response()->json(json_decode($json));
});
