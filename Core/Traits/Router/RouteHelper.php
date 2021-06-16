<?php

namespace Core\Traits\Router;

use Core\Classes\{BaseController, Request, Response};

/**
 * @author @smhdhsn
 * 
 * @version 1.0.0
 */
trait RouteHelper
{
    /**
     * Getting Requested Method.
     * 
     * @since 1.0.0
     * 
     * @return string
     */
    private function getMethod(): string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    /**
     * Getting URL Without Query Parameters.
     * 
     * @since 1.0.0
     * 
     * @return string
     */
    private function requestUri(): string
    {
        return strtok($_SERVER['REQUEST_URI'], '?');
    }

    /**
     * Storing Request Body Or Request Params.
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    private function saveRequest(): void
    {
        $request = $this->getMethod() === 'get'
        ? new Request($_GET)
        : new Request($_POST);

        array_unshift($this->params, $request);
    }

    /**
     * Storing Route's Information Into an Array As a Nested Array.
     * 
     * @since 1.0.0
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
     * Mapping Down The Url Path In Nested Array.
     * 
     * @since 1.0.0
     * 
     * @return array|null
     */
    private function mapRoute(): ?array
    {
        $url = '/' . trim($this->requestUri(), '/');
        $temp = &$this->routes[$this->getMethod()];
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
}
