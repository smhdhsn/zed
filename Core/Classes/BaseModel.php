<?php

namespace Core\Classes;

use Core\Traits\Sequel\{Insert, Update, Delete, Find, Where, Get};

/**
 * @author @smhdhsn
 * 
 * @version 1.0.0
 */
class BaseModel extends Database
{
    use Insert, Update, Find, Delete, Where, Get;

    /**
     * Database Connection.
     * 
     * @since 1.0.0
     * 
     * @var object
     */
    private $connection;

    /**
     * SQL Query.
     * 
     * @since 1.0.0
     * 
     * @var string
     */
    private $query;

    /**
     * Query Statement.
     * 
     * @since 1.0.0
     * 
     * @var object
     */
    private $statement;

    /**
     * Provided Inputs.
     * 
     * @since 1.0.0
     * 
     * @var array
     */
    protected $inputs;

    /**
     * Creates an Instance Of This Class.
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    public function __construct()
    {
        $this->connection = $this->connect();
    }

    /**
     * Instantiating Class.
     * 
     * @since 1.0.0
     * 
     * @return object
     */
    private static function instantiateClass(): object
    {
        $class = get_called_class();

        return new $class();
    }

    /**
     * Preparing Database Connection.
     * 
     * @since 1.0.0
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
     * @since 1.0.0
     * 
     * @return object
     */
    private function bindParams(): object
    {
        foreach ($this->inputs as $key => $chunk) {
            $this->statement->bindParam(":{$key}", $chunk);
        }

        return $this;
    }

    /**
     * Checking If Model's Instance Or Model's Id Exist.
     * 
     * @since 1.0.0
     * 
     * @return object
     */
    private function checkForModelExistance()
    {
        if (! isset($this->id))
            die(
                (new BaseController)->error(
                    Response::ERROR,
                    'Model Not Found !',
                    Response::HTTP_NOT_FOUND
                )
            );
        else
            $this->inputs = ['id' => $this->id];
        
        return $this;
    }

    /**
     * Preparing SQL Syntax For Binding Query Parameters.
     * 
     * @since 1.0.0
     * 
     * @return string
     */
    private function prepareSqlParams(array $inputs): string
    {
        return implode(
            ',',
            array_map(fn($inp) => "\n\t" . array_search($inp, $inputs) . "=:" . array_search($inp, $inputs), $inputs)
        );
    }

    /**
     * Setting Inputs Property As Model Attributes.
     * 
     * @since 1.0.0
     * 
     * @param array $inputs
     * 
     * @return void
     */
    private function setAttributes(array $inputs): void
    {
        foreach ($inputs as $key => $chunk) {
            $this->$key = $chunk;
        }
    }

    /**
     * Getting Last Inserted ID From Database 
     * And Storing It In Model's Inputs Property.
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    private function setLastId(): void
    {
        $statement = $this->connection->query("SELECT LAST_INSERT_ID()");

        $this->inputs = array_merge($this->inputs, ['id' => $statement->fetchColumn()]);
    }
}
