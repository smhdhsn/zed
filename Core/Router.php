<?php

namespace Zed\Framework;

use Zed\Framework\Exception\NotFoundException;
use Zed\Framework\Middleware\Middleware;
use Zed\Framework\{Request, Response};
use Exception;

/**
 * @author @SMhdHsn
 * 
 * @version 1.0.1
 */
final class Router
{
    use Middleware;

    /**
     * Route list.
     * 
     * @since 1.0.1
     * 
     * @var array
     */
    private array $routes = [];

    /**
     * Route parameter(s).
     * 
     * @since 1.0.1
     * 
     * @var array|null
     */
    private ?array $params = [];

    /**
     * Map GET method.
     * 
     * @since 1.0.1
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
     * @since 1.0.1
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
     * @since 1.0.1
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
     * @since 1.0.1
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

    /**
     * Store route's information in an array as a nested array.
     * 
     * @since 1.0.1
     * 
     * @param array|null $middleware
     * @param mixed $callback
     * @param string $method
     * @param string $url
     * 
     * @return void
     */
    private function saveRoute(string $method, string $url, $callback, ?array $middlewares): void
    {
        $url = '/' . trim($url, '/');
        $temp = &$this->routes[$method];
        $exploded = explode('/', $url);

        for ($i = 1; $i < count($exploded); $i++) {
            $index = $exploded[$i][0] == ':' ? '@' : $exploded[$i];
            $temp = &$temp[$index];
        }

        $temp = ['callback' => $callback, 'middlewares' => $middlewares];
    }

    /**
     * Map down the url path in a nested array.
     * 
     * @since 1.0.1
     * 
     * @return array|null
     */
    private function mapRoute(): ?array
    {
        $url = '/' . trim(strtok($_SERVER['REQUEST_URI'], '?'), '/');
        $temp = &$this->routes[strtolower($_SERVER['REQUEST_METHOD'])];
        $exploded = explode('/', $url);
        $params = &$this->params;

        for ($i = 1; $i < count($exploded); $i++) {
            if (array_key_exists($exploded[$i], $temp)) {
                $temp = &$temp[$exploded[$i]];
            } else if (array_key_exists('@', $temp)) {
                $temp = &$temp['@'];
                $params[] = $exploded[$i];
            } else {
                return null;
            }
        }

        return $temp;
    }

    /**
     * Handle request and returning response.
     * 
     * @since 1.0.1
     * 
     * @throws NotFoundException if route is not defined.
     * 
     * @return null|string
     */
    public function resolve(): ?string
    {
        $route = $this->mapRoute();

        if (! is_null($route)) {
            $this->callMiddleware($route['middlewares']);
            $callback = $route['callback'];

            array_unshift(
                $this->params,
                strtolower($_SERVER['REQUEST_METHOD']) === 'get'
                ? new Request($_GET)
                : new Request($_POST)
            );
        }

        switch (gettype($callback)) {
            case 'NULL':
                throw new NotFoundException(Response::INVALID_ROUTE);
                break;
            case 'object':
                return $this->invokeClosure($callback);
                break;
            case 'string':
                return $this->invokeString($callback);
                break;
            case 'array':
                return $this->invokeArray($callback);
                break;
            default:
                throw new Exception('Invalid callback type.');
        }
    }

    /**
     * In case route is defined using "Controller@Action" syntax.
     * 
     * @since 1.0.1
     * 
     * @param string $map
     * 
     * @return string|null
     */
    private function invokeString(string $map): ?string
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
            return $exception->getMessage();
        }
    }

    /**
     * In case route is defined using [Controller::class, 'action'] syntax.
     * 
     * @since 1.0.1
     * 
     * @param array $map
     * 
     * @return string|null
     */
    private function invokeArray(array $map): ?string
    {
        try {
            $callback = [
                new $map[0],
                $map[1]
            ];

            return call_user_func_array($callback, $this->params);
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
    }

    /**
     * In case route callback is a closure.
     * 
     * @since 1.0.1
     * 
     * @param object $callback
     * 
     * @return string|null
     */
    private function invokeClosure(object $callback): ?string
    {
        try {
            return call_user_func_array($callback, $this->params);
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
    }
}
