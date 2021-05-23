<?php

namespace App\Models;

use Core\Classes\Database;
use Core\Traits\Eloquent\{Insert, Update, Where, Delete};

/**
 * @author @smhdhsn
 * 
 * @version 1.2.0
 */
class BaseModel extends Database
{
    use Insert, Update, Where, Delete;

    /**
     * Database Connection.
     * 
     * @since 1.1.0
     * 
     * @var object
     */
    public $connection;

    /**
     * Model's Inputs.
     * 
     * @since 1.2.0
     * 
     * @var array
     */
    private $input;

    /**
     * SQL Query.
     * 
     * @since 1.2.0
     * 
     * @var string
     */
    private $query;

    /**
     * Query Statement.
     * 
     * @since 1.2.0
     * 
     * @var object
     */
    private $statement;

    /**
     * Creates an Instance Of This Class.
     * 
     * @since 1.1.0
     * 
     * @return void
     */
    public function __construct()
    {
        $this->connection = $this->connect();
    }

    /**
     * Preparing Database Connection.
     * 
     * @since 1.2.0
     * 
     * @return object
     */
    private function prepareDatabase(): object
    {
        $this->statement = $this->connection->prepare($this->query);

        return $this;
    }

    /**
     * Binding Input Parameters.
     * 
     * @since 1.2.0
     * 
     * @return object
     */
    private function bindParams(): object
    {
        foreach ($this->input as $key => $chunk) {
            $this->statement->bindParam(":{$key}", htmlspecialchars(strip_tags($chunk)));
        }

        return $this->statement;
    }
}
