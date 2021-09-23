<?php

namespace Zed\Framework\Exception;

use Zed\Framework\{Controller, Response};
use Exception;

/**
 * @author @SMhdHsn
 * 
 * @version 1.0.1
 */
class NotFoundException extends Exception
{
    /**
     * Creates an instance of this class.
     * 
     * @since 1.0.1
     * 
     * @param null|string $message
     * 
     * @return void
     */
    public function __construct(string $message = Response::NOTFOUND)
    {
        parent::__construct(
            (new Controller)->error(
                Response::ERROR,
                $message,
                Response::HTTP_NOT_FOUND
            )
        );
    }
}
