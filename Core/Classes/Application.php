<?php

namespace Core\Classes;

error_reporting(E_ERROR | E_PARSE);
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Content-Type, Authorization, X-Requested-With');

use Exception;

/**
 * @author @smhdhsn
 * 
 * @version 1.0.0
 */
class Application
{
    /**
     * Router's Instance.
     * 
     * @since 1.0.0
     * 
     * @var object
     */
    public Router $router;

    /**
     * Holds an Instance Of This Class.
     * 
     * @since 1.0.0
     * 
     * @var object
     */
    public static Application $instance;

    /**
     * Bootstraping Main Classes.
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    public function __construct()
    {
        self::$instance = $this;
        $this->router = new Router;
    }

    /**
     * Resolving Request.
     * 
     * @since 1.0.0
     * 
     * @throws Exception If Anything Goes Wrong.
     * 
     * @return void
     */
    public function run(): void
    {
        try {
            die(
                $this->router->resolve()
            );
        } catch (Exception $exception) {
            die(
                (new BaseController)->error(
                    Response::ERROR,
                    $exception->getMessage(),
                    Response::HTTP_INTERNAL_SERVER_ERROR
                )
            );
        }
    }
}
