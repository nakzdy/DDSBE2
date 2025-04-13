<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->get('/', function () use ($router) {
    return $router->app->version();
});

// Debug Route (Paste this right after the root route)
$router->get('/debug-key', function () use ($router) {
    return response()->json([
        'key' => env('PASSPORT_PUBLIC_KEY')
    ]);
});

// Unsecured Routes
$router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('/users', 'UserController@index'); // Get all users
    $router->get('/users/{id}', 'UserController@show'); // Get user by ID
    $router->post('/users', 'UserController@add'); // Create a new user
    $router->put('/users/{id}', 'UserController@update'); // Update user
    $router->patch('/users/{id}', 'UserController@update'); // Partial update
    $router->delete('/users/{id}', 'UserController@delete'); // Delete user

    // UserJob Routes
    $router->get('/userjobs', 'UserJobController@index');
    $router->get('/userjobs/{id}', 'UserJobController@show');
});