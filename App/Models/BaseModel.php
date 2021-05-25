<?php

namespace App\Models;

use App\Controllers\BaseController;
use Core\Classes\{Response, Database};
use Core\Traits\Sequel\{Insert, Update, Delete, Find, Where, Get};

/**
 * @author @smhdhsn
 * 
 * @version 1.2.0
 */
class BaseModel extends Database
{
    use Insert, Update, Find, Delete, Where, Get;

    /**
     * Database Connection.
     * 
     * @since 1.1.0
     * 
     * @var object
     */
    private $connection;

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
     * Model's Instance.
     * 
     * @since 1.2.1
     * 
     * @var object
     */
    private $model;

    /**
     * Provided Inputs.
     * 
     * @since 1.2.1
     * 
     * @var array
     */
    protected $inputs;

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
     * Instantiating Class.
     * 
     * @since 1.2.1
     * 
     * @return object
     */
    private static function instantiateClass(): object
    {
        $class = get_called_class();
        $object = new $class();
        $object->model = $object;

        return $object->model;
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
        foreach ($this->inputs as $key => $chunk) {
            $this->statement->bindParam(":{$key}", htmlspecialchars(strip_tags($chunk)));
        }

        return $this;
    }

    /**
     * Checking If Model's Instance Or Model's Id Exist.
     * 
     * @since 1.2.1
     * 
     * @return object
     */
    private function checkForModelExistance()
    {
        if (! isset($this->model) || ! isset($this->id))
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
     * Setting Inputs Property As Model Attributes.
     * 
     * @since 1.2.1
     * 
     * @param array $inputs
     * 
     * @return void
     */
    private function setAttributes(array $inputs): void
    {
        foreach ($inputs as $key => $chunk) {
            $this->model->$key = $chunk;
        }
    }

    /**
     * Getting Last Inserted ID From Database 
     * And Storing It In Model's Inputs Property.
     * 
     * @since 1.2.1
     * 
     * @return void
     */
    private function setLastId(): void
    {
        $statement = $this->connection->query("SELECT LAST_INSERT_ID()");

        $this->inputs = array_merge($this->inputs, ['id' => $statement->fetchColumn()]);
    }
}
