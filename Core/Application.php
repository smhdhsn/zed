<?php

namespace Zed\Framework;

header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Access-Control-Allow-Methods, Content-Type, Authorization, X-Requested-With');
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
error_reporting(E_ERROR | E_PARSE);

use Zed\Framework\Database\{DatabaseCreator, Database};
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
     * @var Router
     */
    public Router $router;

    /**
     * Command's instance.
     * 
     * @since 1.0.0
     * 
     * @var Command
     */
    public Command $command;

    /**
     * Database's instance.
     * 
     * @since 1.0.1
     * 
     * @var Database
     */
    public static Database $database;

    /**
     * Path to project's root folder.
     * 
     * @since 1.0.0
     * 
     * @var string
     */
    public static string $appRoot;

    /**
     * Path to framework's root folder.
     * 
     * @since 1.0.1
     * 
     * @var string
     */
    public static string $frameworkRoot;

    /**
     * Creates an instance of this class.
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    public function __construct(string $root)
    {
        $this->setDatabase();

        self::$appRoot = $root;
        self::$frameworkRoot = dirname(__DIR__);

        $this->router = new Router;
        $this->command = new Command;
    }

    /**
     * Set database's instance.
     * 
     * @since 1.0.1
     * 
     * @return void
     */
    private function setDatabase(): void
    {
        self::$database = (new DatabaseCreator)
            ->getDatabase();
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
