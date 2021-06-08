<?php

namespace Core\Traits\Route;

use Exception;
use Core\Classes\{BaseController, Request, Response};

/**
 * @author @smhdhsn
 * 
 * @version 1.0.0
 */
trait Helper
{
    /**
     * Responding To Request.
     * 
     * @since 1.0.0
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
            : call_user_func_array($action, self::$params)
        );
    }

    /**
     * Preparing Params Depending On Requested Method.
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    private function setRequestBody(): void
    {
        $request = $_SERVER['REQUEST_METHOD'] === 'GET'
        ? new Request($_GET)
        : new Request($_POST);

        array_unshift(self::$params, $request);
    }

    /**
     * Getting URL Without Query Parameters.
     * 
     * @since 1.0.0
     * 
     * @return string
     */
    public function requestUri(): string
    {
        return strtok($_SERVER['REQUEST_URI'], '?');
    }

    /**
     * Checking If Request Method Matches Given Method.
     * 
     * @since 1.0.0
     * 
     * @param string $method
     * 
     * @return bool
     */
    private function methodCheck(string $method): bool
    {
        return $_SERVER['REQUEST_METHOD'] === $method;
    }

    /**
     * Mapping Requested Controller and Method.
     * 
     * @since 1.0.0
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

            $callback = [
                new $class(),
                $parts[1]
            ];

            return call_user_func_array($callback, self::$params);
        } catch (Exception $e) {
            die(
                (new BaseController)->error(
                    Response::ERROR,
                    $e->getMessage(),
                    Response::HTTP_INTERNAL_SERVER_ERROR
                )
            );
        }
    }
    
    /**
     * Checks If Requested URL Matches Route. 
     * Saves Route Parameters If There Is Any.
     * 
     * @since 1.0.0
     * 
     * @param string $route
     * 
     * @return bool
     */
    private function routeCheck(string $route): bool
    {
        $uri = self::requestUri();

        while (strpos($route, '{')) {
            $routeCard = self::getStringBetween($route, '{', '}');

            $leftSide = strpos($route, "{{$routeCard}}");
            $leftVal = substr($route, 0, $leftSide);

            $uriCard = self::getStringBetween($uri, $leftVal, '/');

            $route = str_replace("{{$routeCard}}", $uriCard, $route);

            self::$params[$routeCard] = $uriCard;
        }

        return $route === $uri;
    }

    /**
     * Gets The Block Between Two Strings.
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
        //if (! $ini) return null;
        $ini += strlen($start);
        $len = strpos($string, $end, $ini) - $ini;
        return substr($string, $ini, $len);
    }

    /**
     * Running Middlewares Before Request Gets To Controller Methods.
     * 
     * @since 1.0.0
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
                    $e->getMessage(),
                    Response::HTTP_INTERNAL_SERVER_ERROR
                )
            );
        }
    }

    /**
     * Response For Bad Method Call.
     * 
     * @since 1.0.0
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
}
