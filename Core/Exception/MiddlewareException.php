<?php

namespace Zed\Framework\Exception;

use Zed\Framework\{Controller, Response};
use Exception;

/**
 * @author @SMhdHsn
 * 
 * @version 1.0.1
 */
class MiddlewareException extends Exception
{
    /**
     * Creates an instance of this class.
     * 
     * @since 1.0.1
     * 
     * @param null|string $message
     * @param null|int $code
     * 
     * @return void
     */
    public function __construct(string $message = Response::WORD[Response::HTTP_BAD_REQUEST], int $code = Response::HTTP_BAD_REQUEST)
    {
        parent::__construct(
            (new Controller)->error(
                Response::ERROR,
                $message,
                $code
            )
        );
    }
}
