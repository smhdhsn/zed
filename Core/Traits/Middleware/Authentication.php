<?php

namespace Core\Traits\Middleware;

use Core\Classes\{BaseController, Response, Token};

/**
 * @author @smhdhsn
 * 
 * @version 1.1.0
 */
trait Authentication
{
    /**
     * Checking User's Authentication Status.
     * 
     * @since 1.1.0
     * 
     * @return void
     */
    private static function auth(): void
    {
        if (! (new Token)->verify()) {
            die(
                (new BaseController)->error(
                    Response::ERROR,
                    Response::UNAUTHORIZED,
                    Response::HTTP_UNAUTHORIZED
                )
            );
        }
    }
}
