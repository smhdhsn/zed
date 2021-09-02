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
     * Command's Instance.
     * 
     * @since 1.0.0
     * 
     * @var object
     */
    public Command $command;

    /**
     * Bootstraping Main Classes.
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    public function __construct()
    {
        $this->router = new Router;
        $this->command = new Command;
    }

    /**
     * Resolve Requested Route.
     * 
     * @since 1.0.0
     * 
     * @throws Exception If Anything Goes Wrong.
     * 
     * @return void
     */
    public function resolve(): void
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

    /**
     * Executing Called Command.
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    public function execute(): void
    {
        try {
            die(
                $this->command->execute()
            );
        } catch (Exception $exception) {
            die(
                $exception->getMessage()
            );
        }
    }
}
