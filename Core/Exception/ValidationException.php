<?php

namespace Zed\Framework\Exception;

use Zed\Framework\{Controller, Response};
use Exception;

/**
 * @author @SMhdHsn
 * 
 * @version 1.0.1
 */
class ValidationException extends Exception
{
    /**
     * Creates an instance of this class.
     * 
     * @since 1.0.1
     * 
     * @param mixed $message
     * 
     * @return void
     */
    public function __construct(array $errors)
    {
        parent::__construct(
            (new Controller)->error(
                Response::ERROR,
                $errors,
                Response::HTTP_MISDIRECTED_REQUEST
            )
        );
    }
}
