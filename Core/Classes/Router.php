<?php

namespace Core\Classes;

use Core\Traits\Middleware\Middleware;
use Core\Traits\Router\{Resolve, Helper};

/**
 * @author @smhdhsn
 * 
 * @version 1.0.0
 */
class Router
{
    use Middleware, Resolve, Helper;
    
    /**
     * Application's Routes.
     * 
     * @since 1.0.0
     * 
     * @var array
     */
    private array $routes = [];

    /**
     * Route Parameters.
     * 
     * @since 1.0.0
     * 
     * @var array|null
     */
    private ?array $params = [];

    /**
     * Mapping GET Request.
     * 
     * @since 1.0.0
     * 
     * @param array|null $middlewares
     * @param mixed $callback
     * @param string $url
     * 
     * @return void
     */
    public function get(string $url, $callback, ?array $middlewares = []): void
    {
        $this->saveRoute('get', $url, $callback, $middlewares);
    }

    /**
     * Mapping POST Request.
     * 
     * @since 1.0.0
     * 
     * @param array|null $middlewares
     * @param mixed $callback
     * @param string $url
     * 
     * @return void
     */
    public function post(string $url, $callback, ?array $middlewares = []): void
    {
        $this->saveRoute('post', $url, $callback, $middlewares);
    }

    /**
     * Mapping PUT Request.
     * 
     * @since 1.0.0
     * 
     * @param array|null $middlewares
     * @param mixed $callback
     * @param string $url
     * 
     * @return void
     */
    public function put(string $url, $callback, ?array $middlewares = []): void
    {
        $this->saveRoute('put', $url, $callback, $middlewares);
    }

    /**
     * Mapping DELETE Request.
     * 
     * @since 1.0.0
     * 
     * @param array|null $middlewares
     * @param mixed $callback
     * @param string $url
     * 
     * @return void
     */
    public function delete(string $url, $callback, ?array $middlewares = []): void
    {
        $this->saveRoute('delete', $url, $callback, $middlewares);
    }
}
