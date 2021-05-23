<?php

namespace Core\Traits;

use Exception;
use Core\Classes\Response;
use App\Controllers\BaseController;

/**
 * @author @smhdhsn
 * 
 * @version 1.1.0
 */
trait Helper
{
    /**
     * Responding To Request.
     * 
     * @since 1.1.0
     * 
     * @param closure|string $action
     * 
     * @return void
     */
    private function response($action): void
    {
        die(
            is_string($action) 
            ? self::map($action)
            : $action->__invoke(self::request())
        );
    }

    /**
     * Response For Bad Method Call.
     * 
     * @since 1.1.0
     * 
     * @return void
     */
    private function methodNotAllowed(): void
    {
        die(
            (new BaseController)->error(
                Response::ERROR,
                Response::WORD[Response::HTTP_METHOD_NOT_ALLOWED],
                Response::HTTP_METHOD_NOT_ALLOWED
            )
        );
    }

    /**
     * Mapping Requested Controller and Method.
     * 
     * @since 1.1.0
     * 
     * @param string $action
     * 
     * @throws Exception If Anything Goes Wrong.
     * 
     * @return string JSON Response.
     */
    private function map(string $action): string
    {
        try {
            $parts = explode('@', $action);

            $class = "\\App\\Controllers\\$parts[0]";
            $controller = new $class();
            return $controller->{$parts[1]}(self::request());
        } catch (Exception $e) {
            die(
                (new BaseController)->error(
                    Response::ERROR,
                    'Connection Error: ' . $e->getMessage(),
                    Response::HTTP_INTERNAL_SERVER_ERROR
                )
            );
        }
    }

    /**
     * Preparing Params Depending On Requested Method.
     * 
     * @since 1.1.0
     * 
     * @return array
     */
    private function request(): array
    {
        return $_SERVER['REQUEST_METHOD'] == 'GET'
        ? $_GET
        : $_POST;
    }

    /**
     * Running Middlewares Before Request Gets To Controller Methods.
     * 
     * @since 1.1.0
     * 
     * @param array $middlewares
     * 
     * @throws Exception If Anything Goes Wrong.
     * 
     * @return void
     */
    private function handleMiddlewares(array $middlewares): void
    {
        try {
            foreach ($middlewares as $middleware) {
                self::$middleware();
            }
        } catch (Exception $e) {
            die(
                (new BaseController)->error(
                    Response::ERROR,
                    'Connection Error: ' . $e->getMessage(),
                    Response::HTTP_INTERNAL_SERVER_ERROR
                )
            );
        }
    }
}
