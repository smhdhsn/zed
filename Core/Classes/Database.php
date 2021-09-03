<?php

namespace Core\Classes;

use Core\Classes\BaseController;
use PDOException;
use PDO;

/**
 * @author @smhdhsn
 * 
 * @version 1.0.0
 */
abstract class Database
{
    /**
     * Database Connection.
     * 
     * @since 1.0.0
     * 
     * @var object
     */
    private object $connection;

    /**
     * Connecting To The Database.
     * 
     * @since 1.0.0
     * 
     * @return object
     */
    public function connect(): object
    {
        if (! isset($this->connection)) {
            try {
                $this->connection = new PDO(
                    "mysql:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_NAME']}",
                    $_ENV['DB_USERNAME'],
                    $_ENV['DB_PASSWORD']
                );

                $this->connection->setAttribute(
                    PDO::ATTR_ERRMODE, 
                    PDO::ERRMODE_EXCEPTION
                );
            } catch (PDOException $e) {
                die(
                    (new BaseController)->error(
                        Response::ERROR,
                        'Connection Error: ' . $e->getMessage(),
                        Response::HTTP_INTERNAL_SERVER_ERROR
                    )
                );
            }
        }

        return $this->connection;
    }
}
