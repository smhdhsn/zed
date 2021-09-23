<?php

namespace Zed\Framework;

/**
 * @author @SMhdHsn
 * 
 * @version 1.0.1
 */
abstract class Database
{
    /**
     * Make connection to the database, must be implemented in every sub-class.
     * 
     * @since 1.0.1
     * 
     * @return void
     */
	abstract protected function connect(): void;

    /**
     * Get database connection.
     * 
     * @since 1.0.1
     * 
     * @return object
     */
    final public function getConnection(): object
	{
        if (! $this->connection)
            $this->connect();

        return $this->connection;
	}
}
