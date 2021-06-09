<?php

use Core\Classes\Route;


use App\Models\User;

Route::post('/user/register', 'UserController@register');
Route::get('/user/login', 'UserController@login');

Route::get('/welcome', 'WelcomeController@index', [
    'auth'
]);
