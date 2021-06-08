<?php

namespace Core\Classes;

error_reporting(E_ERROR | E_PARSE);
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Content-Type, Authorization, X-Requested-With');

use Core\Traits\Helper;
use Core\Traits\Middleware\Authentication;

/**
 * @author @smhdhsn
 * 
 * @version 1.0.0
 */
class Route
{
    use Authentication, Helper;

    /**
     * Route Parameters.
     * 
     * @since 1.0.0
     * 
     * @var array|null
     */
    private static array $params = [];

    /**
     * Handling GET Requests.
     * 
     * @since 1.0.0
     * 
     * @param array|null $middlewares
     * @param closure|string $action
     * @param string $route
     * 
     * @return void
     */
    public static function get(string $route, $action, array $middlewares = null): void
    {
        if (self::routeCheck($route) && self::methodCheck('GET')) {
            self::setRequestBody();

            ! isset($middlewares) ?: self::handleMiddlewares($middlewares);

            self::response($action);
        }
    }

    /**
     * Handling POST Requests.
     * 
     * @since 1.0.0
     * 
     * @param array|null $middlewares
     * @param closure|string $action
     * @param string $route
     * 
     * @return void
     */
    public static function post(string $route, $action, array $middlewares = null): void
    {
        if (self::routeCheck($route) && self::methodCheck('POST')) {
            self::setRequestBody();

            ! isset($middlewares) ?: self::handleMiddlewares($middlewares);

            self::response($action);
        }
    }

    /**
     * Handling PUT Requests.
     * 
     * @since 1.0.0
     * 
     * @param array|null $middlewares
     * @param closure|string $action
     * @param string $route
     * 
     * @return void
     */
    public static function put(string $route, $action, array $middlewares = null): void
    {
        if (self::routeCheck($route) && self::methodCheck('PUT')) {
            self::setRequestBody();

            ! isset($middlewares) ?: self::handleMiddlewares($middlewares);

            self::response($action);
        }
    }

    /**
     * Handling DELETE Requests.
     * 
     * @since 1.0.0
     * 
     * @param array|null $middlewares
     * @param closure|string $action
     * @param string $route
     * 
     * @return void
     */
    public static function delete(string $route, $action, array $middlewares = null): void
    {
        if (self::routeCheck($route) && self::methodCheck('DELETE')) {
            self::setRequestBody();

            ! isset($middlewares) ?: self::handleMiddlewares($middlewares);

            self::response($action);
        }
    }

    /**
     * Handling Requests Mathcing Given Methods.
     * 
     * @since 1.0.0
     * 
     * @param closure|string $action
     * @param array $middlewares
     * @param array $methods
     * @param string $route
     * 
     * @return void
     */
    public static function match(array $methods, string $route, $action, array $middlewares = null): void
    {
        if (self::routeCheck($route)) {
            self::setRequestBody();

            foreach ($methods as $method) {
                if (self::methodCheck($method)) {
                    ! isset($middlewares) ?: self::handleMiddlewares($middlewares);

                    self::response($action);
                }
            }
        }
    }
}
