<?php

namespace Core\Traits\Sequel;

use PDO;
use PDOException;
use Core\Classes\{BaseController, Response};

/**
 * @author @smhdhsn
 * 
 * @version 1.0.0
 */
trait Insert
{
    /**
     * Storing Model Into Database.
     * 
     * @since 1.0.0
     * 
     * @param array $inputs
     * 
     * @return object
     */
    public function create(array $inputs): object
    {
        return self::instantiateClass()
            ->makeCreateQuery($inputs)
            ->prepareDatabase()
            ->bindParams()
            ->createAndFetch();
    }

    /**
     * Making Query For Creating Model.
     * 
     * @since 1.0.0
     * 
     * @return object
     */
    private function makeCreateQuery(array $inputs): object
    {
        $this->inputs = $inputs;

        $this->query = "INSERT INTO \n\t{$this->table} \nSET" 
        . $this->prepareSqlParams($inputs);

        return $this;
    }

    /**
     * Executing Query And Fetching Data.
     * 
     * @since 1.0.0
     * 
     * @return object
     */
    private function createAndFetch(): object
    {
        try {
            if ($this->statement->execute())
                $this->setModelAttributes();

            return $this;
        } catch (PDOException $e) {
            die(
                (new BaseController)->error(
                    Response::ERROR,
                    $e->getMessage(),
                    Response::HTTP_BAD_REQUEST
                )
            );
        }
    }

    /**
     * Setting Model's Attributes.
     * 
     * @since 1.0.0
     * 
     * @return void
     */
    private function setModelAttributes(): void
    {
        $this->setLastId();
        $this->setAttributes($this->inputs);
    }
}
