<?php

use Core\Classes\Route;


use App\Models\User;

Route::get('/user', function (\Core\Classes\Request $request) {
    
    $user = User::create([
        'name' => $request->name,
        'surname' => $request->surname,
        'email' => $request->email,
        'username' => $request->username,
        'password' => $request->password,
        'phone_number' => $request->phone_number,
    ]);

    //$user = User::find(2);

    $user->update([
        'name' => $request->name,
        'surname' => $request->surname,
        'email' => $request->email,
        'username' => $request->username,
        'password' => $request->password,
        'phone_number' => $request->phone_number,
    ]);

    var_dump($user->phone_number);
    die();
});


Route::post('/user/register', 'UserController@register');
Route::get('/user/login', 'UserController@login');

Route::get('/welcome', 'WelcomeController@index', [
    'auth'
]);
