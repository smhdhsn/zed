<?php

namespace Core\Traits\Router;

use Core\Classes\{BaseController, Request, Response};

/**
 * @author @smhdhsn
 * 
 * @version 1.0.0
 */
trait Helper
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
     * Storing Route's Information Into an Array.
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
        $this->routes[$method][$url]['callback'] = $callback;
        $this->routes[$method][$url]['middlewares'] = $middlewares;
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
     * Matching Given Route With Requested URI.
     * Saves Route Parameters If There Is Any.
     * 
     * @since 1.0.0
     * 
     * @param string $route
     * 
     * @return string
     */
    private function getUrl(string $route): string
    {
        $uri = $this->requestUri();

        while (strpos($route, '{')) {
            $routeCard = $this->getStringBetween($route, '{', '}');

            $leftSide = strpos($route, "{{$routeCard}}");
            $leftVal = substr($route, 0, $leftSide);

            $uriCard = $this->getStringBetween($uri, $leftVal, '/');

            $route = str_replace("{{$routeCard}}", $uriCard, $route);

            $this->params[$routeCard] = $uriCard;
        }

        return $route;
    }

    /**
     * Gets The String Block Between Two String Blocks.
     * 
     * @since 1.0.0
     * 
     * @param string $string
     * @param string $start
     * @param string $end
     * 
     * @return string|null
     */
    public function getStringBetween(string $string, string $start, string $end): ?string
    {
        $ini = strpos($string, $start);
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }
}
