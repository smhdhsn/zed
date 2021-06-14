<?php

namespace Core\Traits\Router;

use Exception;
use Core\Classes\{BaseController, Response};

/**
 * @author @smhdhsn
 * 
 * @version 1.0.0
 */
trait Resolve
{
    /**
     * Handling Request And Returning Response.
     * 
     * @since 1.0.0
     * 
     * @return string|null
     */
    public function resolve(): ?string
    {
        $route = $this->mapRoute();
        
        if (! is_null($route)) {
            $this->callMiddleware($route['middlewares']);
            $callback = $route['callback'];
            $this->saveRequest();
        }

        switch (gettype($callback)) {
            case 'NULL':
                return $this->resolveNotFound();
            break;
            case 'array':
                return $this->resolveArray($callback);
            break;
            case 'string':
                return $this->resolveString($callback);
            break;
            case 'object':
                return $this->resolveClosure($callback);
            break;
        }
    }

    /**
     * In Case Route Is Set Using "Controller@Action" Syntax.
     * 
     * @since 1.0.0
     * 
     * @param string $map
     * 
     * @return string|null
     */
    private function resolveString(string $map): ?string
    {
        try {
            $parts = explode('@', $map);

            $class = "\\App\\Controllers\\$parts[0]";

            $callback = [
                new $class(),
                $parts[1]
            ];

            return call_user_func_array($callback, $this->params);
        } catch (Exception $exception) {
            return (new BaseController)->error(
                Response::ERROR,
                $exception->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * In Case Route Is Set Using [Controller::class, 'action'] Syntax.
     * 
     * @since 1.0.0
     * 
     * @param array $map
     * 
     * @return string|null
     */
    private function resolveArray(array $map): ?string
    {
        try {
            $callback = [
                new $map[0],
                $map[1]
            ];

            return call_user_func_array($callback, $this->params);
        } catch (Exception $exception) {
            return (new BaseController)->error(
                Response::ERROR,
                $exception->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * In Case Route Callback Is a Closure.
     * 
     * @since 1.0.0
     * 
     * @param object $callback
     * 
     * @return string|null
     */
    private function resolveClosure(object $callback): ?string
    {
        try {
            return call_user_func_array($callback, $this->params);
        } catch (Exception $exception) {
            return (new BaseController)->error(
                Response::ERROR,
                $exception->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    /**
     * When Requested Route Doesn't Match Match Any Routes In Application.
     * 
     * @since 1.0.0
     * 
     * @return string
     */
    private function resolveNotFound(): string
    {
        return (new BaseController)->error(
            Response::ERROR,
            Response::INVALID_ROUTE,
            Response::HTTP_NOT_FOUND
        );
    }
}
