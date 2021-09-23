<?php

namespace Zed\Framework\Middleware;

use Zed\Framework\Exception\MiddlewareException;
use Zed\Framework\{Response, Token};

/**
 * @author @SMhdHsn
 * 
 * @version 1.0.1
 */
trait Authentication
{
    /**
     * Checking User's Authentication Status.
     * 
     * @since 1.0.1
     * 
     * @return void
     */
    final private static function auth(): void
    {
        if (! (new Token)->verify())
            throw new MiddlewareException(
                Response::UNAUTHORIZED, 
                Response::HTTP_UNAUTHORIZED
            );
    }
}
