<?php

namespace Zed\Framework\Traits\Middleware;

use Zed\Framework\{Controller, Response};
use Exception;

/**
 * @author @SMhdHsn
 * 
 * @version 1.0.0
 */
trait Middleware
{
    use Authentication;
    
    /**
     * Running Route Middlewares Before Request Reaches Any Further.
     * 
     * @since 1.0.0
     * 
     * @param array|null $middlewares
     * 
     * @throws Exception If Anything Goes Wrong.
     * 
     * @return void
     */
    private function callMiddleware(?array $middlewares): void
    {
        try {
            foreach ($middlewares as $middleware) {
                $this->$middleware();
            }
        } catch (Exception $exception) {
            die(
                (new Controller)->error(
                    Response::ERROR,
                    $exception->getMessage(),
                    Response::HTTP_INTERNAL_SERVER_ERROR
                )
            );
        }
    }
}
