<?php

/*
|--------------------------------------------------------------------------
| API routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. 
|
*/

$router->post('/user/register', 'UserController@register');
$router->get('/user/login', 'UserController@login');

$router->get('/welcome', 'WelcomeController@index', [
    'auth'
]);
