<?php

use Core\Classes\{BaseController, Response, Route};

/**
 * When Route Is Not Defined.
 * 
 * @since 1.2.1
 */
Route::match(['GET', 'POST', 'PUT', 'DELETE'], $_SERVER['REQUEST_URI'], function () {
    return (new BaseController)->error(
            Response::ERROR,
            'Invalid Route.',
            Response::HTTP_NOT_FOUND
        );
});
