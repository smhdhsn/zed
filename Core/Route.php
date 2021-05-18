<?php

namespace Core;

error_reporting(E_ERROR | E_PARSE);
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Content-Type, Authorization, X-Requested-With');

/**
 * @author @smhdhsn
 * 
 * @version 1.0.0
 */
abstract class Route
{
    /**
     * Handling GET Requests.
     * 
     * @since 1.0.0
     * 
     * @param closure|string $action
     * @param string $route
     * 
     * @return void
     */
    public static function get(string $route, $action): void
    {
        if ($_SERVER['REQUEST_URI'] == $route && $_SERVER['REQUEST_METHOD'] == 'GET') {
            if (is_string($action)) {
                $parts = explode('@', $action);

                $class = "\App\Controllers\\$parts[0]";
                $controller = new $class();
                echo $controller->{$parts[1]}();
            } else {
                echo $action->__invoke();
            }
            die();
        }
    }

    /**
     * Handling POST Requests.
     * 
     * @since 1.0.0
     * 
     * @param closure|string $action
     * @param string $route
     * 
     * @return void
     */
    public static function post(string $route, $action): void
    {
        if ($_SERVER['REQUEST_URI'] == $route && $_SERVER['REQUEST_METHOD'] == 'POST') {
            if (is_string($action)) {
                $parts = explode('@', $action);

                $class = "\App\Controllers\\$parts[0]";
                $controller = new $class();
                echo $controller->{$parts[1]}();
            } else {
                echo $action->__invoke();
            }
            die();
        }
    }

    /**
     * Handling PUT Requests.
     * 
     * @since 1.0.0
     * 
     * @param closure|string $action
     * @param string $route
     * 
     * @return void
     */
    public static function put(string $route, $action): void
    {
        if ($_SERVER['REQUEST_URI'] == $route && $_SERVER['REQUEST_METHOD'] == 'PUT') {
            if (is_string($action)) {
                $parts = explode('@', $action);

                $class = "\App\Controllers\\$parts[0]";
                $controller = new $class();
                echo $controller->{$parts[1]}();
            } else {
                echo $action->__invoke();
            }
            die();
        }
    }

    /**
     * Handling DELETE Requests.
     * 
     * @since 1.0.0
     * 
     * @param closure|string $action
     * @param string $route
     * 
     * @return void
     */
    public static function delete(string $route, $action): void
    {
        if ($_SERVER['REQUEST_URI'] == $route && $_SERVER['REQUEST_METHOD'] == 'DELETE') {
            if (is_string($action)) {
                $parts = explode('@', $action);

                $class = "\App\Controllers\\$parts[0]";
                $controller = new $class();
                echo $controller->{$parts[1]}();
            } else {
                echo $action->__invoke();
            }
            die();
        }
    }
}
