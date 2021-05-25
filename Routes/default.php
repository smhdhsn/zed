<?php

use Core\Classes\Route;

/**
 * When Route Is Not Defined.
 * 
 * @since 1.2.1
 * 
 * @return string
 */
Route::get($_SERVER['REQUEST_URI'], 'BaseController@notFound');
Route::put($_SERVER['REQUEST_URI'], 'BaseController@notFound');
Route::post($_SERVER['REQUEST_URI'], 'BaseController@notFound');
Route::delete($_SERVER['REQUEST_URI'], 'BaseController@notFound');
