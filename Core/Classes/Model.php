<?php

namespace Core\Classes;

use Core\Traits\Sequel\{Insert, Update, Delete, Find, Where, Get};

/**
 * @author @SMhdHsn
 * 
 * @version 1.0.0
 */
class Model extends Database
{
    use Insert, Update, Find, Delete, Where, Get;

    /**
     * Database connection.
     * 
     * @since 1.0.0
     * 
     * @var object
     */
    private object $connection;

    /**
     * SQL query.
     * 
     * @since 1.0.0
     * 
     * @var string
     */
    private string $query;

    /**
     * Query statement.
     * 
     * @since 1.0.0
     * 
     * @var object
     */
    private object $statement;

    /**
     * Provided inputs.
     * 
     * @since 1.0.0
     * 
     * @var array
     */
    protected array $inputs;

    /**
     * Creates an instance of this class.
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
     * Instantiate class.
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
     * Prepare database connection.
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
     * Check if model's instance or model's id are present.
     * 
     * @since 1.0.0
     * 
     * @return object
     */
    private function checkForModelExistance(): object
    {
        if (! isset($this->id))
            die(
                (new Controller)->error(
                    Response::ERROR,
                    'Model not found !',
                    Response::HTTP_NOT_FOUND
                )
            );
        else
            $this->inputs = ['id' => $this->id];
        
        return $this;
    }

    /**
     * Prepare SQL syntax for binding query parameters.
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
     * Prepare columns for query.
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
     * Set input properties as model attributes.
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
     * Get last inserted id from database and store it in model's input property.
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
