<?php

use Core\Classes\{BaseController, Response, Route};

/**
 * When Route Is Not Defined.
 * 
 * @since 1.2.1
 */
Route::match([$_SERVER['REQUEST_METHOD']], $_SERVER['REQUEST_URI'], function () {
    return (new BaseController)->error(
            Response::ERROR,
            'Invalid Route.',
            Response::HTTP_NOT_FOUND
        );
});
