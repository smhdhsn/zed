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
    private object $connection;

    /**
     * SQL Query.
     * 
     * @since 1.0.0
     * 
     * @var string
     */
    private string $query;

    /**
     * Query Statement.
     * 
     * @since 1.0.0
     * 
     * @var object
     */
    private object $statement;

    /**
     * Provided Inputs.
     * 
     * @since 1.0.0
     * 
     * @var array
     */
    protected array $inputs;

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
     * Checking If Model's Instance Or Model's Id Exist.
     * 
     * @since 1.0.0
     * 
     * @return object
     */
    private function checkForModelExistance(): object
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
    private function prepareParams(array $inputs): string
    {
        return implode(
            ',',
            array_map(fn($inp) => "\n\t" . array_search($inp, $inputs) . "=:" . array_search($inp, $inputs), $inputs)
        );
    }

    /**
     * Preparing Columns For Query.
     * 
     * @since 1.0.0
     * 
     * @param string|null $prefix
     * 
     * @return string
     */
    private function prepareColumns(?string $prefix): string
    {
        return implode(
            ',',
            array_map(fn($inp) => "\n\t{$prefix}" . array_search($inp, $this->inputs), $this->inputs)
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

    /**
     * Get model's table name from property table inside model's instance.
     * If it's not defined, it'll be gotten from reflection class on called
     * class's instance.
     * 
     * @since 1.0.0
     * 
     * @return string
     */
    private function getTableName(): string
    {
        if ($this->table)
            return $this->table;

        return strtolower((new \ReflectionClass(get_called_class()))->getShortName());
    }
}
