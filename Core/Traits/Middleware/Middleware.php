<?php

namespace Core\Traits\Middleware;

use Exception;
use Core\Classes\{BaseController, Response};

/**
 * @author @smhdhsn
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
    private function handleMiddlewares(?array $middlewares): void
    {
        try {
            foreach ($middlewares as $middleware) {
                $this->$middleware();
            }
        } catch (Exception $exception) {
            die(
                (new BaseController)->error(
                    Response::ERROR,
                    $exception->getMessage(),
                    Response::HTTP_INTERNAL_SERVER_ERROR
                )
            );
        }
    }
}
