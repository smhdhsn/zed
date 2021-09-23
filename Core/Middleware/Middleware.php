<?php

namespace Zed\Framework\Middleware;

use Zed\Framework\Exception\MiddlewareException;
use Exception;

/**
 * @author @SMhdHsn
 * 
 * @version 1.0.1
 */
trait Middleware
{
    use Authentication;

    /**
     * Execute middlewares before request reaches any further.
     * 
     * @since 1.0.1
     * 
     * @param array|null $middlewares
     * 
     * @throws MiddlewareException if there are any middleware falures.
     * 
     * @return void
     */
    final private function callMiddleware(?array $middlewares): void
    {
        try {
            foreach ($middlewares as $middleware) {
                $this->$middleware();
            }
        } catch (Exception $exception) {
            throw new MiddlewareException($exception->getMessage());
        }
    }
}
