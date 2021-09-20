<?php

namespace Core\Classes;

header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Content-Type, Authorization, X-Requested-With');
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
error_reporting(E_ERROR | E_PARSE);

use Exception;

/**
 * @author @SMhdHsn
 * 
 * @version 1.0.0
 */
class Application
{
    /**
     * Router's instance.
     * 
     * @since 1.0.0
     * 
     * @var object
     */
    public Router $router;

    /**
     * Command's instance.
     * 
     * @since 1.0.0
     * 
     * @var object
     */
    public Command $command;

    /**
     * Path to the root of the project.
     * 
     * @since 1.0.0
     * 
     * @var string
     */
    public static string $root;

    /**
     * Creates an instance of this class.
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    public function __construct(string $root)
    {
        self::$root = $root;
        $this->router = new Router;
        $this->command = new Command;
    }

    /**
     * Resolve requested route.
     * 
     * @since 1.0.0
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
                (new Controller)->error(
                    Response::ERROR,
                    $exception->getMessage(),
                    Response::HTTP_INTERNAL_SERVER_ERROR
                )
            );
        }
    }

    /**
     * Execute called command.
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
