<?php

namespace Zed\Framework\Database\Platform;

use Zed\Framework\Database;
use PDOException;
use PDO;

/**
 * @author @SMhdHsn
 * 
 * @version 1.0.1
 */
final class MySQL extends Database
{
    /**
     * MySQL connection.
     * 
     * @since 1.0.1
     * 
     * @var null|object
     */
    protected ?object $connection = null;

    /**
     * Connect to MySQL database.
     * 
     * @since 1.0.1
     * 
     * @throws PDOException if anything goes wrong while connecting to the database.
     *  
     * @return void
     */
    protected function connect(): void
    {
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
        } catch (PDOException $exception) {
            throw $exception;
        }
    }
}
