<?php

namespace Core\Classes;

use Core\Traits\Router\{RouteHelper as Helper, RouteResolve as Resolve};
use Core\Traits\Middleware\Middleware;

/**
 * @author @SMhdHsn
 * 
 * @version 1.0.0
 */
class Router
{
    use Middleware, Resolve, Helper;
    
    /**
     * Route list.
     * 
     * @since 1.0.0
     * 
     * @var array
     */
    private array $routes = [];

    /**
     * Route parameter(s).
     * 
     * @since 1.0.0
     * 
     * @var array|null
     */
    private ?array $params = [];

    /**
     * Map GET method.
     * 
     * @since 1.0.0
     * 
     * @param string $url
     * @param mixed $callback
     * @param array|null $middlewares
     * 
     * @return void
     */
    public function get(string $url, $callback, ?array $middlewares = []): void
    {
        $this->saveRoute('get', $url, $callback, $middlewares);
    }

    /**
     * Map POST method.
     * 
     * @since 1.0.0
     * 
     * @param string $url
     * @param mixed $callback
     * @param array|null $middlewares
     * 
     * @return void
     */
    public function post(string $url, $callback, ?array $middlewares = []): void
    {
        $this->saveRoute('post', $url, $callback, $middlewares);
    }

    /**
     * Map PUT method.
     * 
     * @since 1.0.0
     * 
     * @param string $url
     * @param mixed $callback
     * @param array|null $middlewares
     * 
     * @return void
     */
    public function put(string $url, $callback, ?array $middlewares = []): void
    {
        $this->saveRoute('put', $url, $callback, $middlewares);
    }

    /**
     * Map DELETE method.
     * 
     * @since 1.0.0
     * 
     * @param string $url
     * @param mixed $callback
     * @param array|null $middlewares
     * 
     * @return void
     */
    public function delete(string $url, $callback, ?array $middlewares = []): void
    {
        $this->saveRoute('delete', $url, $callback, $middlewares);
    }
}
